<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\RegistrationForm;
use Application\Form\LoginForm;

/**
 * 
 */
class UserController extends AbstractActionController {
    
    /**
     * This action displays the Registration page.
     * @return \Zend\View\Model\ViewModel
     */
    public function registerAction() {
        
        // Create Registration form
        $form = new RegistrationForm();
        
        // Check if user has submitted the form
        if($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            
            
            $form->setData($data);
                        
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                
                
            }            
        } 
        
        // Pass form variable to view
        return new ViewModel(array(
            'form' => $form
        ));
    }
    
    /**
     * This action displays the Login page.
     * @return \Zend\View\Model\ViewModel
     */
    public function loginAction() {
        
        // Create Registration form
        $form = new LoginForm();
        
        // Check if user has submitted the form
        if($this->getRequest()->isPost()) {
            
            $fieldId = $this->params()->fromQuery('fieldId', null);
            if($fieldId!=null)
                $form->setValidationGroup($fieldId);
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            
            
            $form->setData($data);
                        
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                
                
            }            
        } 
        
        // Pass form variable to view
        $viewModel = new ViewModel(array(
            'form' => $form,
            'isAJAX'=> $this->getRequest()->isXmlHttpRequest()
        ));
        
        if($this->getRequest()->isXmlHttpRequest()) {
            $viewModel->setTemplate('application/user/form.phtml');
            $viewModel->setTerminal(true);
        }
        
        return $viewModel;
    }
}
