<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Barcode\Barcode;
use Zend\Version\Version;
use Zend\Mvc\MvcEvent;

/**
 * This is the main controller class of the Hello World application. The 
 * controller class is used to receive user input, instantiate needed models, 
 * pass the data to the models and pass the results returned by models to the 
 * view for rendering.
 */
class IndexController extends AbstractActionController {
    
    /**
     * This is the default "index" action of the controller. It displays the 
     * Home page.
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() {
                
        return new ViewModel();
    }

    /**
     * This is the "about" action. It is used to display the "About" page.
     * @return \Zend\View\Model\ViewModel
     */
    public function aboutAction() {              
                
        // Get current ZF version
        $zendFrameworkVer = Version::VERSION;        
        // Fetch the latest available version of ZF
        $latestVer = Version::getLatest();
        // Test if newer version is available
        $isNewerVerAvailable = Version::compareVersion($latestVer);
        
        // Return variables to view script with the help of
        // ViewObject variable container
        return new ViewModel(array(
            'zendFrameworkVer' => $zendFrameworkVer,
            'isNewerVerAvailable' => $isNewerVerAvailable,
            'latestVer' => $latestVer
        ));
    }
    
    /**
     * This action displays the Downloads page.
     */
    public function downloadsAction() {
        return new ViewModel();
    }
    
    /**
     * This is the 'download' action that is invoked
     * when a user wants to download the given file.     
     */
    public function downloadAction() 
    {
        // Get the file name from GET variable
        $fileName = $this->params()->fromQuery('file', '');
        
        // Take some precautions to Make file name secure
        str_replace("/", "", $fileName);  // Remove slashes
        str_replace("\\", "", $fileName); // Remove back-slashes
        
        // Try to open file
        $path = './data/download/' . $fileName;
        if (!is_readable($path)) {
            // Set 404 Not Found status code
            $this->getResponse()->setStatusCode(404);            
            return;
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

    /**
     * This is the "doc" action which displays a "static" 
     * documentation page.
     */
    public function docAction() {
        
        $pageTemplate = 'application/index/doc'.$this->params()->fromRoute('page', 'documentation.phtml');        
        $filePath = __DIR__.'/../../../view/'.$pageTemplate.'.phtml';
        if(!file_exists($filePath) || !is_readable($filePath)) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $viewModel = new ViewModel(array(
            'page'=>$pageTemplate
        ));
        $viewModel->setTemplate($pageTemplate);
        
        return $viewModel;
    }
    
    /**
     * This is the "static" action which displays a static
     * documentation page.
     */
    public function staticAction() {
     
        // Get path to view template from route params
        $pageTemplate = $this->params()->fromRoute('page', null);
        if($pageTemplate==null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Render the page
        $viewModel = new ViewModel(array(
            'page'=>$pageTemplate
        ));
        $viewModel->setTemplate($pageTemplate);
        return $viewModel;
    }
    
    /**
     * This is the "barcode" action. It generate the HELLO-WORLD barcode image.     
     */
    public function barcodeAction() {
        
        // Get parameters from route.
        $type = $this->params()->fromRoute('type', 'code39');
        $label = $this->params()->fromRoute('label', 'HELLO-WORLD');

        // Set barcode options.
        $barcodeOptions = array('text' => $label);        
        $rendererOptions = array();
        
        // Create barcode object
        $barcode = Barcode::factory(
                $type, 'image', $barcodeOptions, $rendererOptions
                );
        
        // The line below will output barcode image to standard output stream.
        $barcode->render();

        // Return false to disable default view rendering. 
        return false;
    }  
    
    /**
     * This action has no special meaning except the demonstration of the use 
     * of Wildcard route type.     
     * To see how this works, type "http://localhost/blog/year/2013/month/April/name/my-vacation"
     */
    public function blogAction() {
        
        // Get parameters from the route.
        $year = $this->params()->fromRoute('year', null);
        $month = $this->params()->fromRoute('month', null);
        $name = $this->params()->fromRoute('name', null);
        
        if($name!=null)
            echo 'You requested to see the blog post named "'.$name.'"';
        else
            echo 'You requested to see all blog posts';
        
        if($year!=null && $month!=null)
            echo ' published in '.$month.' '.$year;
        else if($year!=null)
            echo ' published in '.$year;
        else
            echo ' published in the past';
            
        // Suppress default view rendering.
        return $this->getResponse();
    }
    
    /**
     * An action that demonstrates the usage of partial views.
     */
    public function partialDemoAction() {
        
        $products = array(
            array(
                'id' => 1,
                'name' => 'Digital Camera',
                'price' => 99.95,
            ),
            array(
                'id' => 2,
                'name' => 'Tripod',
                'price' => 29.95,
            ),
            array(
                'id' => 3,
                'name' => 'Camera Case',
                'price' => 2.99,
            ),
            array(
                'id' => 4,
                'name' => 'Batteries',
                'price' => 39.99,
            ),
            array(
                'id' => 5,
                'name' => 'Charger',
                'price' => 29.99,
            ),
        );
        
        return new ViewModel(array(
                'products' => $products
            ));
    }
    
    /** 
     * We override the parent class' onDispatch() method to
     * set an alternative layout for all actions in this controller.
     */
    public function onDispatch(MvcEvent $e) {
        
        // Call the base class' onDispatch() first and grab the response
        $response = parent::onDispatch($e);        
        
        // Set alternative layout
        $this->layout()->setTemplate('layout/layout2');                
        
        // Return the response
        return $response;
    }    
}
