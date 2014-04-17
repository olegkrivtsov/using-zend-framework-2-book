<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\ContactForm;
use Application\Service\MailSender;
use Zend\Filter\Null;

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
        
        // Create Contact Us form
        $form = new ContactForm();
        
        // Check if user has submitted the form
        if($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            
            
            $form->setData($data);
            
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                $email = $data['email'];
                $subject = $data['subject'];
                $body = $data['body'];
                
                // Send E-mail
                $mailSender = new MailSender();
                if(!$mailSender->sendMail('no-reply@example.com', $email, $subject, $body)) {
                    // In case of error, redirect to "Error Sending Email" page
                    return $this->redirect()->toRoute('application/default', 
                        array('controller'=>'index', 'action'=>'sendError'));
                }
                
                // Redirect to "Thank You" page
                return $this->redirect()->toRoute('application/default', 
                        array('controller'=>'index', 'action'=>'thankYou'));
            }               
        } 
        
        // Pass form variable to view
        return new ViewModel(array(
            'form' => $form
        ));
    }
    
    /**
     * This action displays the Thank You page. The user is redirected to this
     * page on successful mail delivery.
     * @return \Zend\View\Model\ViewModel
     */
    public function thankYouAction() {
                
        return new ViewModel();
    }
    
    /**
     * This action displays the Send Error page. The user is redirected to this
     * page on mail delivery error.
     * @return \Zend\View\Model\ViewModel
     */
    public function sendErrorAction() {
                
        return new ViewModel();
    }
}
