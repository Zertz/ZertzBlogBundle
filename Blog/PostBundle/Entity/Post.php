<?php
namespace Zertz\Blog\PostBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table("zertz_blog__post")
 * @ORM\Entity(repositoryClass="Zertz\Blog\PostBundle\Entity\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Zertz\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false)
     */
    protected $author;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    protected $headline;

    /**
     * @Gedmo\Slug(fields={"headline"}, updatable=true, unique=true, separator="-", style="default")
     * @ORM\Column(type="string", length=45)
     */
    protected $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $rawContent;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isPublished;
    
    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $publishedAt;
    
    /**
     * @ORM\OneToOne(targetEntity="Zertz\Blog\MediaBundle\Entity\Photo", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $leadmedia;
    
    /**
     * @ORM\OneToMany(targetEntity="Zertz\Blog\PostBundle\Entity\postHasMedias", mappedBy="post", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $medias;
    
    /**
     * @ORM\OneToMany(targetEntity="Zertz\Blog\PostBundle\Entity\postHasSources", mappedBy="post", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $sources;
    
    /**
     * @ORM\OneToMany(targetEntity="Zertz\Blog\PostBundle\Entity\postHasTags", mappedBy="post", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $tags;
    
    public function __construct() {
        $this->medias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString() {
        return $this->headline ?: '';
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

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set headline
     *
     * @param string $headline
     * @return Post
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;
    
        return $this;
    }

    /**
     * Get headline
     *
     * @return string 
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set lead media
     *
     * @param Zertz\MediaBundle\Entity\Media $leadmedia
     * @return self
     */
    public function setLeadMedia($leadmedia)
    {
        $this->leadmedia = $leadmedia;
    
        return $this;
    }

    /**
     * Get lead media
     *
     * @return Zertz\MediaBundle\Entity\Media 
     */
    public function getLeadMedia()
    {
        return $this->leadmedia;
    }

    /**
     * Set raw content
     *
     * @param string $rawContent
     * @return self
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;
    
        return $this;
    }

    /**
     * Get raw content
     *
     * @return string 
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * @param boolean $isPublished
     * @return self
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    
        return $this;
    }

    /**
     * @return boolean 
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * Set published
     *
     * @param date $published
     * @return self
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    
        return $this;
    }

    /**
     * Get published
     *
     * @return date 
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }
    
    /**
    * Set medias
    *
    * @param $medias
    */
    public function setMedias($medias)
    {
        $this->medias = new ArrayCollection();
        
        foreach ($medias as $m) {
            $this->addMedia($m);
        }
        
        return $this;
    }
    
    /**
    * Add media
    *
    * @param Zertz\Blog\PostBundle\Entity\postHasMedias $media
    */
    public function addMedia(\Zertz\Blog\PostBundle\Entity\postHasMedias $media)
    {
        $media->setPost($this);
        
        $this->medias->add($media);
    }
    
    /**
    * Remove media
    *
    * @param Zertz\Blog\PostBundle\Entity\postHasMedias $media
    */
    public function removeMedia(\Zertz\Blog\PostBundle\Entity\postHasMedias $media)
    {
        $this->medias->removeElement($media);
    }
    
    /**
    * Get medias
    *
    * @return Doctrine\Common\Collections\Collection
    */
    public function getMedias()
    {
        return $this->medias;
    }
    
    /**
    * Set sources
    *
    * @param $sources
    */
    public function setSources($sources)
    {
        $this->sources = new ArrayCollection();
        
        foreach ($sources as $s) {
            $this->addSource($s);
        }
        
        return $this;
    }
    
    /**
    * Add source
    *
    * @param Zertz\Blog\PostBundle\Entity\postHasSources $source
    */
    public function addSource(\Zertz\Blog\PostBundle\Entity\postHasSources $source)
    {
        $source->setPost($this);
        
        $this->sources->add($source);
    }
    
    /**
    * Remove source
    *
    * @param Zertz\Blog\PostBundle\Entity\postHasSources $source
    */
    public function removeSource(\Zertz\Blog\PostBundle\Entity\postHasSources $source)
    {
        $this->sources->removeElement($source);
    }
    
    /**
    * Get sources
    *
    * @return Doctrine\Common\Collections\Collection
    */
    public function getSources()
    {
        return $this->sources;
    }
    
    /**
    * Set tags
    *
    * @param $tags
    */
    public function setTags($tags)
    {
        $this->tags = new ArrayCollection();
        
        foreach ($tags as $t) {
            $this->addTag($t);
        }
        
        return $this;
    }
    
    /**
    * Add tag
    *
    * @param Zertz\Blog\PostBundle\Entity\postHasTags $tag
    */
    public function addTag(\Zertz\Blog\PostBundle\Entity\postHasTags $tag)
    {
        $tag->setPost($this);
        
        $this->tags->add($tag);
    }
    
    /**
    * Remove tag
    *
    * @param Zertz\Blog\PostBundle\Entity\postHasTags $tag
    */
    public function removeTag(\Zertz\Blog\PostBundle\Entity\postHasTags $tag)
    {
        $this->tags->removeElement($tag);
    }
    
    /**
    * Get tags
    *
    * @return Doctrine\Common\Collections\Collection
    */
    public function getTags()
    {
        return $this->tags;
    }
}
