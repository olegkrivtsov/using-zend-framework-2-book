<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a tag.
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag {
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** 
     * @ORM\Column(name="name") 
     */
    protected $name;

    /** 
     * @ORM\Column(name="content")  
     */
    protected $content;

    /** 
     * @ORM\Column(name="status")  
     */
    protected $status;

    /** 
     * @ORM\Column(name="date_created") 
     */
    protected $date_created;
    
    /**
     * Constructor.
     */
    public function __construct() {        
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
     * Returns name.
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets title.
     * @param string $name
     */
    public function setName($name) {
        $this->title = $name;
    }
}

