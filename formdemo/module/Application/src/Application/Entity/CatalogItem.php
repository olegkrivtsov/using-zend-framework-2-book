<?php
namespace Application\Entity;

/**
 * This entity class represents a catalog item. An item has a title and a price.
 */
class CatalogItem {
    
    /**
     * Unique catalog item's ID.
     * @var int 
     */
    private $id;
    
    /**
     * Item's human-readable title.
     * @var string 
     */
    private $title;
    
    /**
     * Item's price
     * @var float
     */
    private $price;

    /**
     * This method returns item's ID.     
     * @return int
     */
    public function getID() {
        return $this->id;
    }
    
    /**
     * This method sets item's ID.     
     * @param int $id Unique ID of the item.
     */
    public function setID($id) {
        $this->id = $id;
    }
    
    /**
     * This method returns item's title.
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }
    
    /**
     * This method sets item's title.     
     * @param string $title Title of the item.
     */
    public function setTitle($title) {
        $this->title = $title;
    }
    
    /**
     * This method returns item's price.
     * @return float
     */
    public function getPrice() {
        return $this->price;
    }
    
    /**
     * This method sets item's price.     
     * @param float $price Price of the item.
     */
    public function setPrice($price) {
        $this->price = $price;
    }
}