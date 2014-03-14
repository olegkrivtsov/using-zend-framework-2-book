<?php
namespace Application\Entity;

/**
 * This entity class represents a user.
 */
class User {
    
    // User titles.
    const TITLE_MISTER = 'Mr.';
    const TITLE_MISSIS = 'Mrs.';
    
    /**
     * Unique user's ID.
     * @var int 
     */
    private $id;
    
    /**
     * User login.
     * @var string
     */
    private $login;
    
    /**
     * Mr./Mrs.
     * @var string 
     */
    private $title;
    
    /**
     * User's first name.
     * @var string 
     */
    private $firstName;
    
    /**
     * User's last name.
     * @var string
     */
    private $lastName;
    
    /**
     *
     * @var type 
     */
    private $password;
    
    /**
     *
     * @var type 
     */
    private $birthDate;
    
    /**
     * Country name.
     * @var string 
     */
    private $country;
    
    /**
     * Street address.
     * @var string
     */
    private $address;
    
    /**
     * City name.
     * @var string
     */
    private $city;
    
    /** 
     * ZIP code
     * @var string 
     */
    private $zipCode;
    
    /**
     * This method returns user's ID.     
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * This method sets user's ID.     
     * @param int $id Unique ID of the user.
     */
    public function setID($id) {
        $this->id = $id;
    }
    
    /**
     * This method returns user's title (Mr./Mrs.).
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }
    
    /**
     * This method sets user's title.     
     * @param string $title Title of the user.
     */
    public function setTitle($title) {
        $this->title = $title;
    }
    
    /**
     * This method returns user's first name.
     * @return string
     */
    public function getFirstName() {
        return $this->firstName;
    }
    
    /**
     * This method sets user's first name.     
     * @param float $firstName First name of the user.
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }
    
    /**
     * This method returns user's last name.
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
    }
    
    /**
     * This method sets user's last name.     
     * @param float $firstName Last name of the user.
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }
    
    public function getLogin() {
        return $this->login;
    }
    
}

