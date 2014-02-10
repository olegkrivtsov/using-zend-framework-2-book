<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * This controller is designed for managing image file uploads.
 */
class ImageController extends AbstractActionController {
    
    /**
     * This is the default "index" action of the controller. It displays the 
     * Images page.
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() {
        
        $dir = "./data/upload";
        
        if(!is_dir($dir)) {
            if(!mkdir($dir)) {
                throw new \Exception('Could not create directory for uploads: '. error_get_last());
            }
        }
        
        // Open uploads directory
        $files = array();
        $dh  = opendir($dir);
        while (false !== ($filename = readdir($dh))) {
            $files[] = $filename;
        }
        
        return new ViewModel($files);
    }
    
    
}
