<?php
namespace Zertz\Blog\MediaBundle\Entity\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class PhotoManager
{
    protected $em;
    
    protected $repo;
    
    protected $class;
    
    public function __construct(EntityManager $em, $class) {
        $this->em = $em;
        $this->class = $class;
        $this->repo = $em->getRepository($class);
    }
    
    public function findAll($limit, $offset) {
        return $this->repo->findBy(array(
            
        ), array(
            'updatedAt' => 'ASC',
        ), $limit, $offset);
    }
}
