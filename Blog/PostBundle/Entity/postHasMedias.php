<?php
namespace Zertz\Blog\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table("zertz_blog__post_medias")
 */
class postHasMedias
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Zertz\Blog\PostBundle\Entity\Post", inversedBy="medias")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false)
     */
    protected $post;
    
    /**
     * @ORM\ManyToOne(targetEntity="Zertz\Blog\MediaBundle\Entity\Photo")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", nullable=false)
     */
    protected $media;

    /**
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    protected $position;
    
    public function getId()
    {
        return $this->id;
    }

    public function setPost(\Zertz\Blog\PostBundle\Entity\Post $post)
    {
        $this->post = $post;
    }

    public function getPost()
    {
        return $this->post;
    }
    
    public function setMedia(\Zertz\Blog\MediaBundle\Entity\Photo $media)
    {
        $this->media = $media;
    
        return $this;
    }
    
    public function getMedia()
    {
        return $this->media;
    }
    
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }
    
    public function getPosition()
    {
        return $this->position;
    }
}
