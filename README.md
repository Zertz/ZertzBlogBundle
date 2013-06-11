ZertzBlogBundle
========================

WARNING: Not ready for prime-time, still in very early development

This bundle provides a simple blogging platform built on top of Symfony2 and is
also a great way to jump start a project.

### Features
- Rich-text editing
- Sources
- Tags

### Upcoming features
- Comments
- Galleries
- Support for multiple blogs

1) Requirements
----------------------------------

There are very few requirements to get the bundle up and running, the most
important being a working installation of Symfony 2.

2) Installation
----------------------------------

### Using Composer

In composer.json, add:

    "require": {
        "zertz/blog-bundle": "dev-master"
    }

Run an update to download the bundles:

    php composer.phar update

3) Configuration
----------------------------------

### AppKernel.php

Enable the bundles:

    public function registerBundles()
    {
        $bundles = array(
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\FacebookBundle\FOSFacebookBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\jQueryBundle\SonatajQueryBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            
            new Zertz\Blog\PostBundle\ZertzBlogPostBundle(),
            new Zertz\Blog\MediaBundle\ZertzBlogMediaBundle(),
            new Zertz\Blog\SortBundle\ZertzBlogSortBundle(),
            new Zertz\PhotoBundle\ZertzPhotoBundle(),
            new Zertz\SortBundle\ZertzSortBundle(),
            new Zertz\UserBundle\ZertzUserBundle(),
        );
    }

### config.yml

User management must be configured as follows and for Facebook integration, you
must provide valid API configuration.

    fos_user:
        db_driver: orm
        firewall_name: public
        user_class: Zertz\UserBundle\Entity\User

    fos_facebook:
        alias:  facebook
        app_id: 1 # Your application id
        secret: 1 # Your secret key
        cookie: true
        permissions: [email]

The following configuration is for SonataAdminBundle.

    framework:
        translator:      { fallback: %locale% }
        default_locale:  "%locale%"

    doctrine:
        dbal:
            types:
                json: Sonata\Doctrine\Types\JsonType

    sonata_admin:
        title:      Your Application
        title_logo: /bundles/sonataadmin/logo_title.png
        templates:
            layout:  SonataAdminBundle::standard_layout.html.twig
            ajax:    SonataAdminBundle::ajax_layout.html.twig
            list:    SonataAdminBundle:CRUD:list.html.twig
            show:    SonataAdminBundle:CRUD:show.html.twig
            edit:    SonataAdminBundle:CRUD:edit.html.twig
        dashboard:
            blocks:
                - { position: left, type: sonata.admin.block.admin_list }
            groups:
                Blog: ~

    sonata_block:
        default_contexts: [cms]
        blocks:
            sonata.admin.block.admin_list:
                contexts: [admin]
            sonata.block.service.text:
            sonata.block.service.rss:

StofDoctrineExtensionsBundle

    stof_doctrine_extensions:
        default_locale: %locale%
        orm:
            default:
                sluggable: true
                timestampable: true

### routing.yml

This bundle does not provide any routes, you are free to use whatever you want.
However, you must define these to enable SonataAdminBundle:

    admin:
        resource: '@SonataAdminBundle/Resources/config/routing/sonata_admin.xml'
        prefix: /admin

    _sonata_admin:
        resource: .
        type: sonata_admin
        prefix: /admin

    sonata_user:
        resource: '@SonataUserBundle/Resources/config/routing/admin_security.xml'
        prefix: /admin

### services.yml

Move this in ZertzUserBundle?

    services:
        # FOSFacebookBundle
        fos_user.facebook:
            class: Zertz\UserBundle\Security\User\Provider\FacebookProvider
            arguments:
                facebook: "@fos_facebook.api"
                userManager: "@fos_user.user_manager"
                validator: "@validator"
                container: "@service_container"

### security.yml

This is the basic configuration needed for security, it works out of the box,
but you may need to add a firewall or customize access_control.

    security:
        encoders:
            FOS\UserBundle\Model\UserInterface: sha512

        role_hierarchy:
            ROLE_ADMIN:       ROLE_USER
            ROLE_SUPER_ADMIN: [ROLE_USER, ROLE_SONATA_ADMIN, ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]

        providers:
            chain_provider:
                chain:
                    providers: [fos_facebook_provider, fos_userbundle]
            fos_facebook_provider:
                id: fos_user.facebook
            fos_userbundle:
                id: fos_user.user_manager

        firewalls:
            admin:
                pattern: /admin(.*)
                form_login:
                    provider: fos_userbundle
                    login_path: /admin/login
                    use_forward: false
                    check_path: /admin/login_check
                    failure_path: null
                logout:
                    path: /admin/logout
                anonymous: true

        access_control:
            - { path: ^/admin/login$, role: IS_AUTHENTICATED_ANONYMOUSLY }
            - { path: ^/admin/logout$, role: IS_AUTHENTICATED_ANONYMOUSLY }
            - { path: ^/admin/login-check$, role: IS_AUTHENTICATED_ANONYMOUSLY }
            - { path: ^/admin, role: ROLE_ADMIN }
            - { path: ^/.*, role: [IS_AUTHENTICATED_ANONYMOUSLY] }

4) Database
----------------------------------

Run the following command to update the database schema:

    php app/console doctrine:schema:update --force

5) Usage
----------------------------------

The bundle provides services through which data can be fetched as well as
helpers for common needs.

In your controller, you can add a function to get the service:

    protected function getBlogManager()
    {
        return $this->container->get('zertz.blog');
    }

Then, a very simple action could look like:

    /**
     * @Route("/blog/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1}, name="blog")
     */
    public function indexAction($page)
    {
        return $this->render('AppCoreBundle:Blog:index.html.twig', array(
            'page' => $page,
            'posts' => $this->getBlogManager()->setPostsPerPage(10)->getPage($page),
            'postsPerPage' => $this->getBlogManager()->getPostsPerPage(),
        ));
    }
