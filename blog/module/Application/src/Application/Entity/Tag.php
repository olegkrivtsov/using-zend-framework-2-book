<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a tag.
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag 
{
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
     * @ORM\ManyToMany(targetEntity="\Application\Entity\Post", mappedBy="tags")
     */
    protected $posts;
    
    /**
     * Constructor.
     */
    public function __construct() 
    {        
        $this->posts = new ArrayCollection();        
    }

    /**
     * Returns ID of this tag.
     * @return integer
     */
    public function getId() 
    {
        return $this->id;
    }

    /**
     * Sets ID of this tag.
     * @param int $id
     */
    public function setId($id) 
    {
        $this->id = $id;
    }

    /**
     * Returns name.
     * @return string
     */
    public function getName() 
    {
        return $this->name;
    }

    /**
     * Sets title.
     * @param string $name
     */
    public function setName($name) 
    {
        $this->name = $name;
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
     * 
     * @return type
     */
    public function getPosts() 
    {
        return $this->posts;
    }
    
    /**
     * 
     * @param type $post
     */
    public function addPost($post) 
    {
        $this->posts[] = $post;        
    }
}

