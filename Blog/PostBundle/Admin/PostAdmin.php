<?php
namespace Zertz\Blog\PostBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class PostAdmin extends Admin
{
    private $securityContext;
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getSubject()->getId();
        
        $formMapper
            ->with('General')
                ->add('headline')
                ->add('leadmedia', 'entity', array(
                    'class' => 'ZertzBlogMediaBundle:Photo',
                    'empty_value' => 'None',
                    'label' => 'Lead photo',
                    'required' => false,
                    /*'query_builder' => function(\Doctrine\ORM\EntityRepository $er) use ($id) {
                        return $er->createQueryBuilder('q')
                            ->where('q.post = :id')
                            ->orderBy('q.filename', 'ASC')
                            ->setParameter('id', $id)
                        ;
                    },*/
                ))
                ->add('rawContent', 'ckeditor', array(
                    'label' => 'Content',
                    'config' => array(
                        /*'filebrowserUploadUrl' => $this->generateUrl('media_upload', array(
                            'postId' => $this->getRequest()->get('id'),
                        )),*/
                        'toolbar' => array(
                            array(
                                'name'  => 'document',
                                'items' => array('Source', '-', 'Preview', 'Print'),
                            ),
                            array(
                                'name' => 'clipboard',
                                'items' => array('Undo', 'Redo'),
                            ),
                            array(
                                'name' => 'links',
                                'items' => array('Link', 'Unlink'),
                            ),
                            array(
                                'name' => 'insert',
                                'items' => array(/*'Image', */'Table', 'HorizontalRule'),
                            ),
                            '/',
                            array(
                                'name'  => 'basicstyles',
                                'items' => array('Bold', 'Italic', 'Underline', '-', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'),
                            ),
                            array(
                                'name' => 'paragraph',
                                'items' => array('JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent')
                            ),
                        ),
                        'ui_color' => '#ffffff',
                        'width' => 800,
                        'height' => 300,
                    )
                ))
                ->add('isPublished', 'checkbox', array(
                    'required' => false,
                    'label' => 'Published',
                ))
            ->with('Sources')
                ->add('sources', 'sonata_type_collection', array(
                    'required' => false,
                ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ))
                ->end()
            ->with('Medias')
                ->add('medias', 'sonata_type_collection', array(
                    'required' => false,
                ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ))
                ->end()
            ->with('Tags')
                ->add('tags', 'sonata_type_collection', array(
                    'required' => false,
                ), array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ))
                ->end()
        ;
    }
    
    /*protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('media_upload', '{postId}/media/upload', array(
            '_controller' => 'ZertzBlogBundle:Media:upload',
        ), array(
            'postId' => '\d+',
        ));
    }*/
    
    public function setSecurityContext($securityContext)
    {
        $this->securityContext = $securityContext;
    }
    
    public function prePersist($post)
    {
        $this->preUpdate($post);
    }

    public function preUpdate($post)
    {
        $post->setAuthor($this->securityContext->getToken()->getUser());
        
        $post->setMedias($post->getMedias());
        $post->setSources($post->getSources());
        $post->setTags($post->getTags());
        
        if ($post->getIsPublished()) {
            $post->setPublishedAt(new \DateTime('now'));
        } else {
            $post->setPublishedAt(null);
        }
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('headline')
            ->add('author')
            ->add('isPublished')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('headline')
            ->add('author')
            ->add('isPublished')
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->end()
        ;
    }
}
