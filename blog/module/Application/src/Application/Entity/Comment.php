<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a comment related to a blog post.
 * @ORM\Entity()
 * @ORM\Table(name="post")
 */
class Comment {
    
    // Comment status constants
    const STATUS_VISIBLE = 1;
    const STATUS_HIDDEN  = 2;

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(name="title")  * */
    protected $title;

    /** @ORM\Column(name="body")  * */
    protected $body;

    /** @ORM\Column(name="status")  * */
    protected $status;

    /** @ORM\Column(name="publication_date")  * */
    protected $publicationDate;

    /**
     * @ORM\OneToMany(targetEntity="Application\Entity\Comment", mappedBy="post")
     * @ORM\JoinColumn(name="id", referencedColumnName="post_id")
     * */
    protected $comments;
    
    /**
     * Constructor.
     */
    public function __construct() {
        $this->comments = new ArrayCollection();        
    }

    /**
     * Returns ID of this post.
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets ID of this post.
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Returns title.
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Sets title.
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Returns status.
     * @return integer
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Sets status.
     * @param integer $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * Returns status as a string.
     * @return string 
     */
    public function getStatusStr() {

        switch ($this->_status) {
            case self::STATUS_ACTIVE: return 'Active';
                break;
            case self::STATUS_HIDDEN: return 'Hidden';
                break;
            default: return 'Unknown';
                break;
        }
    }
    
}

