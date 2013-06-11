<?php

namespace Zertz\Blog\SortBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Zertz\SortBundle\Entity\Tag as BaseTag;

/**
 * @ORM\Table(name="zertz_blog__tag")
 * @ORM\Entity
 */
class Tag extends BaseTag
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
