<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\ImageForm;

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
            
            if($filename=='.' || $fileName='..')
                    continue;
            
            $files[] = $filename;
        }
        
        return new ViewModel(array(
            'files'=>$files
            ));
    }
    
    /**
     * This action shows image upload form.
     */
    public function uploadAction() {
        
        $form = new ImageForm();
        
        // Check if user has submitted the form
        if($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            
            
            // Pass data to form
            $form->setData($data);
            
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                
                // Redirect to "Images" page
                return $this->redirect()->toRoute('application/default', 
                        array('controller'=>'image', 'action'=>'index'));
            }            
        } 
        
        // Render the page
        return new ViewModel(array(
                    'form' => $form
                ));
    }
    
}
