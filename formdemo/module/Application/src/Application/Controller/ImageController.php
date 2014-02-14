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
        $handle  = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            
            if($entry=='.' || $entry=='..')
                    continue;
            
            $files[] = $entry;
        }
        
        return new ViewModel(array(
            'files'=>$files
            ));
    }
    
    /**
     * This action shows image upload form.
     */
    public function uploadAction() {
        
        // Create the form model
        $form = new ImageForm();
        
        // Check if user has submitted the form
        if($this->getRequest()->isPost()) {
            
            // Make certain to merge the files info!
            $request = $this->getRequest();
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            
            // Pass data to form
            $form->setData($data);
            
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                             
                move_uploaded_file($data['file']['tmp_name'], './data/upload/'.$data['file']['name']);
                
                // Redirect to "Images" page
                return $this->redirect()->toRoute('application/default', 
                        array('controller'=>'image', 'action'=>'index'));
            }            
            
            $errors = $form->getMessages();
            var_dump($errors);            
        } 
        
        // Render the page
        return new ViewModel(array(
                    'form' => $form
                ));
    }
    
    /**
     * This is the 'file' action that is invoked
     * when a user wants to download the given file.     
     */
    public function fileAction() 
    {
        // Get the file name from GET variable
        $fileName = $this->params()->fromQuery('name', '');
        
        // 
        $isThumbnail = (bool)$this->params()->fromQuery('thumbnail', false);
                
        // Take some precautions to Make file name secure
        str_replace("/", "", $fileName);  // Remove slashes
        str_replace("\\", "", $fileName); // Remove back-slashes
        
        // Try to open file
        $path = './data/upload/' . $fileName;
        if (!is_readable($path)) {
            // Set 404 Not Found status code
            $this->getResponse()->setStatusCode(404);            
            return;
        }
        
        list($width_orig, $height_orig) = getimagesize($path);

        if($isThumbnail) {
            
            $width = 240;
            $ratio_orig = $width_orig/$height_orig;
            $height = $width/$ratio_orig;

            // resample
            $image_p = imagecreatetruecolor($width, $height);
            $image = imagecreatefromjpeg($path);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

            // output
            $path = tempnam("/tmp", "FOO");
            imagejpeg($image_p, $path, 80);
        }
        
        // Get file size in bytes
        $fileSize = filesize($path);

        // Write HTTP headers
        $response = $this->getResponse();
        $headers = $response->getHeaders();
        $headers->addHeaderLine("Content-type: application/octet-stream");
        $headers->addHeaderLine("Content-Disposition: attachment; filename=\"" . $fileName . "\"");
        $headers->addHeaderLine("Content-length: $fileSize");
        $headers->addHeaderLine("Cache-control: private"); //use this to open files directly
            
        // Write file content        
        $fileContent = file_get_contents($path);
        if($fileContent!=false) {                
            $response->setContent($fileContent);
        } else {        
            // Set 500 Server Error status code
            $this->getResponse()->setStatusCode(500);
            return;
        }
        
        // Return Response to avoid default view rendering
        return $this->getResponse();
    }
    
}
