<?php

/**
 * Model representing on-disk image file.
 */
class ImageFile {
        
    /**
     * Name of the file.
     * @var string 
     */
    private $fileName;
    
    /**
     * Constructor.
     */
    public function __construct($fileName) {
        
        $this->fileName = $fileName;
    }    
    
}