<?php
namespace Zertz\Blog\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table("zertz_blog__post_sources")
 */
class postHasSources
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Zertz\Blog\PostBundle\Entity\Post", inversedBy="sources")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false)
     */
    protected $post;
    
    /**
     * @ORM\ManyToOne(targetEntity="Zertz\Blog\PostBundle\Entity\Source")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id", nullable=false)
     */
    protected $source;

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
    
    public function setSource(\Zertz\Blog\PostBundle\Entity\Source $source)
    {
        $this->source = $source;
    
        return $this;
    }
    
    public function getSource()
    {
        return $this->source;
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
