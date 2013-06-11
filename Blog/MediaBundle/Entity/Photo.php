<?php

namespace Zertz\Blog\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Zertz\PhotoBundle\Entity\Photo as BasePhoto;

/**
 * @ORM\Table(name="zertz_blog__photo")
 * @ORM\Entity(repositoryClass="Zertz\Blog\MediaBundle\Entity\Repository\PhotoRepository")
 */
class Photo extends BasePhoto
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
    
    public function __toString()
    {
        return $this->filename ?: '';
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
