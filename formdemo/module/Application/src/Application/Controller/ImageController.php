<?php
/**
 * The controller which manages image file uploads.
 */
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
     * Images page which contains the list of uploaded images.
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() {
        
        // Get the singleton of the image manager service.
        $imageManager = $this->getServiceLocator()->get('ImageManager');
        
        // Get the list of uploaded files.
        $files = $imageManager->getUploadedFiles();
        
        // Render the view template
        return new ViewModel(array(
            'files'=>$files
            ));
    }
    
    /**
     * This action shows the image upload form. This page allows to upload 
     * a single file.
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
                
                // Move uploaded file to its persistent location
                $dstFileName = './data/upload/'.$data['file']['name'];
                if(!move_uploaded_file($data['file']['tmp_name'], $dstFileName)) {
                    throw new \Exception('Could move uploaded file: '. error_get_last());
                }
                
                // Redirect the user to "Images" page
                return $this->redirect()->toRoute('application/default', 
                        array('controller'=>'image', 'action'=>'index'));
            }                        
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
        
        // Check whether the user needs a thumbnail or a full-size image
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
        
        if($isThumbnail) {
        
            $imageManager = $this->getServiceLocator()->get('ImageManager');
            
            $path = $imageManager->resizeImage($path);
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
        
        if($isThumbnail) {
            // Remove temporary file
            unlink($path);
        }
        
        // Return Response to avoid default view rendering
        return $this->getResponse();
    }
    
}
