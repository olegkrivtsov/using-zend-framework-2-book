<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\ContactForm;

/**
 * This is the main controller class of the Form Demo application. The 
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
     * This action displays the About page.
     * @return \Zend\View\Model\ViewModel
     */
    public function aboutAction() {
                
        return new ViewModel();
    }
    
    /**
     * This action displays the Contact Us page.
     * @return \Zend\View\Model\ViewModel
     */
    public function contactUsAction() {
        
        $form = new ContactForm();
        
        return new ViewModel(array(
            'form' => $form
        ));
    }
}
