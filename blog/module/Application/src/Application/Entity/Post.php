<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Entity\Comment;
use Application\Entity\Tag;

/**
 * This class represents a single post in a blog.
 * @ORM\Entity()
 * @ORM\Table(name="post")
 */
class Post {
    
    // Post status constants.
    const STATUS_DRAFT       = 1; // Draft.
    const STATUS_PUBLISHED   = 2; // Published.

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(name="title")  **/
    protected $title;

    /** @ORM\Column(name="content")  **/
    protected $content;

    /** @ORM\Column(name="status")  **/
    protected $status;

    /** @ORM\Column(name="date_created")  **/
    protected $dateCreated;

    /**
     * @ORM\OneToMany(targetEntity="Application\Entity\Comment", mappedBy="post")
     * @ORM\JoinColumn(name="id", referencedColumnName="post_id")
     **/
    protected $comments;
    
    /**
     * @ORM\ManyToMany(targetEntity="Application\Entity\Tag", mappedBy="post")
     * @ORM\JoinColumn(name="id", referencedColumnName="post_id")
     **/
    protected $tags;
    
    /**
     * Constructor.
     */
    public function __construct() 
    {
        $this->comments = new ArrayCollection();        
        $this->tags = new ArrayCollection();        
    }

    /**
     * Returns ID of this post.
     * @return integer
     */
    public function getId() 
    {
        return $this->id;
    }

    /**
     * Sets ID of this post.
     * @param int $id
     */
    public function setId($id) 
    {
        $this->id = (int)$id;
    }

    /**
     * Returns title.
     * @return string
     */
    public function getTitle() 
    {
        return $this->title;
    }

    /**
     * Sets title.
     * @param string $title
     */
    public function setTitle($title) 
    {
        $this->title = (string)$title;
    }

    /**
     * Returns status.
     * @return integer
     */
    public function getStatus() 
    {
        return $this->status;
    }

    /**
     * Sets status.
     * @param integer $status
     */
    public function setStatus($status) 
    {
        $this->status = (int)$status;
    }

    /**
     * Returns status as a string.
     * @return string 
     */
    public function getStatusStr() 
    {
        switch ($this->_status) {
            case self::STATUS_DRAFT: return 'Draft';
                break;
            case self::STATUS_PUBLISHED: return 'Published';
                break;
            default: return 'Unknown';
                break;
        }
    }
    
    /**
     * Returns post content.
     */
    public function getContent() 
    {
       return $this->content; 
    }
    
    /**
     * Sets post content.
     * @param type $content
     */
    public function setContent($content) 
    {
        $this->content = (string)$content;
    }
    
    /**
     * Returns the date when this post was created.
     * @return string
     */
    public function getDateCreated() 
    {
        return $this->dateCreated;
    }
    
    /**
     * Sets the date when this post was created.
     * @param string $dateCreated
     */
    public function setDateCreated($dateCreated) 
    {
        $this->dateCreated = (string)$dateCreated;
    }
    
    /**
     * Returns the date when this post was last modified.
     * @return string
     */
    public function getDateModified() 
    {
        return $this->dateModified;
    }
    
    /**
     * Returns comments for this post.
     * @return array
     */
    public function getComments() 
    {
        return $this->comments;
    }
    
    /**
     * Adds a new comment to this post.
     * @param $comment
     */
    public function addComment($comment) 
    {
        if($comment===null || !($comment instanceof Comment))
            throw new \Exception('Comment must be an instance of the Application\Entity\Comment class');
        
        $this->comments[] = $comment;
    }
    
    /**
     * Returns tags for this post.
     * @return array
     */
    public function getTags() 
    {
        return $this->tags;
    }
    
    /**
     * 
     * @param type $tagsStr
     */
    public function setTagsFromString($tagsStr) 
    {
        $tags = explode($tagsStr, ',');
    }
}

