<?php
namespace Zertz\Blog\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table("zertz_blog__post_tags")
 */
class postHasTags
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Zertz\Blog\PostBundle\Entity\Post", inversedBy="tags")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false)
     */
    protected $post;
    
    /**
     * @ORM\ManyToOne(targetEntity="Zertz\Blog\SortBundle\Entity\Tag")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id", nullable=false)
     */
    protected $tag;

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
    
    public function setTag(\Zertz\Blog\SortBundle\Entity\Tag $tag)
    {
        $this->tag = $tag;
    
        return $this;
    }
    
    public function getTag()
    {
        return $this->tag;
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
