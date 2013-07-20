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
use Doctrine\ORM\EntityManager;

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

        $entityManager = $this->getServiceLocator()
                ->get('doctrine.entitymanager.orm_default');
        
        return new ViewModel();
    }

    /**
     * This is the "about" action. It is used to display the "About" page.
     * @return \Zend\View\Model\ViewModel
     */
    public function aboutAction() {

        $zendFrameworkVer = \Zend\Version\Version::VERSION;
        $isNewerVerAvailable = \Zend\Version\Version::compareVersion($zendFrameworkVer);
        $latestVer = \Zend\Version\Version::getLatest();

        return new ViewModel(array(
            'zendFrameworkVer' => $zendFrameworkVer,
            'isNewerVerAvailable' => $isNewerVerAvailable,
            'latestVer' => $latestVer
        ));
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

    /**
     * Returns ORM entity manager. Through the manager we can access database
     * tables.
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager() {

        if (null === $this->_entityManager) {
            $this->_entityManager =
                    $this->getServiceLocator()
                    ->get('doctrine.entitymanager.orm_default');
        }

        return $this->_entityManager;
    }

}
