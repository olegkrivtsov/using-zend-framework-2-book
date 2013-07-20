<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Barcode\Barcode;
use Zend\Version\Version;

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
     * 
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
     * This is the "barcode" action. It generate the HELLO-WORLD barcode image.     
     */
    public function barcodeAction() {
        
        // Get parameters from URL
        $barcodeType = $this->params()->fromRoute('type', 'code39');
        $label = $this->params()->fromRoute('label', 'HELLO-WORLD');
        
        // Set barcode options
        $barcodeOptions = array('text' => $label);        
        $rendererOptions = array();
        
        // Create barcode object
        $barcode = Barcode::factory(
                $barcodeType, 'image', $barcodeOptions, $rendererOptions
                );
        
        // The line below will output barcode image to standard output stream.
        $barcode->render();

        // Return false to disable default view rendering 
        return false;
    }  
}
