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
use Application\Form\ContactForm;

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
     * This is the "contact" action which displays the "Contact Us" form.     
     */
    public function contactUsAction() {
        
        // Create Contact Us form
        $form = new \Application\Form\ContactForm();
        $isSubmitted = false;
        
        // Check if user has submitted the form
        if($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->getRequest()->getPost();            
            $form->setData($data);
            
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $validData = $form->getData();
                $email = $validData['email'];
                $subject = $validData['subject'];
                $body = $validData['body'];
                
                // Send E-mail
                $mailSender = new \Application\Service\MailSender();
                $mailSender->sendMail($email, $subject, $body);
                
                // Add flash message
                $this->flashMessenger()->addSuccessMessage(
                        'Thank you! We will respond to you using the E-mail address you\'ve provided');                
                
                $isSubmitted = true;
            }            
        } 
        
        // Pass form variable to view
        return new ViewModel(array(
            'form' => $form,
            'isSubmitted' => $isSubmitted
        ));
    }
}


