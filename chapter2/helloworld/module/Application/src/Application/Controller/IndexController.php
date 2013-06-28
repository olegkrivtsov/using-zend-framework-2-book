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

/**
 * This is the main controller class for the Hello World application. The 
 * controller class is used to receive user input, instantiate needed models, 
 * pass the data to the models and pass the results returned by models to the 
 * view for rendering.
 */
class IndexController extends AbstractActionController
{
    /**
     * This is the default "index" action of the controller. It displays the 
     * "Hello World!" page.
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        return new ViewModel();
    }
        
    /**
     * This is the "about" action. It is used to display the "About" page.
     * @return \Zend\View\Model\ViewModel
     */
    public function aboutAction()
    {
        return new ViewModel();
    }
    
    /**
     * This is the "contact" action. It displays the "Contact Us" page.
     * @return \Zend\View\Model\ViewModel
     */
    public function contactAction()
    {
        return new ViewModel();
    }
    
    public function barcodeAction()
    {
        // Only the text to draw is required
        $barcodeOptions = array('text' => '12345678');

        // No required options
        $rendererOptions = array();
        Barcode::factory(
            'identcode', 'image', $barcodeOptions, $rendererOptions
        )->render();
        
        return false;
    }
}
