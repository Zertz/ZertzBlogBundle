<?php
namespace Zertz\Blog\PostBundle\Entity\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class PostManager
{
    protected $em;
    
    protected $repo;
    
    protected $class;
    
    protected $postsPerPage = 5;
    
    public function __construct(EntityManager $em, $class) {
        $this->em = $em;
        $this->class = $class;
        $this->repo = $em->getRepository($class);
    }
    
    public function getPage($page)
    {
        return $this->repo->findByPublished($this->getPostsPerPage(), $this->getPostsPerPage() * ($page - 1));
    }
    
    public function get($slug)
    {
        return $this->repo->findOneByPublishedAndSlug($slug);
    }
    
    public function getPageCount()
    {
        return ceil($this->repo->countAllPublished() / $this->getPostsPerPage());
    }
    
    public function setPostsPerPage($postsPerPage)
    {
        $this->postsPerPage = $postsPerPage;
        
        return $this;
    }
    
    public function getPostsPerPage()
    {
        return $this->postsPerPage;
    }
}
