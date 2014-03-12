<?php
/**
 * This form is used to collect user's login and password.
 */       
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;

/**
 * This form is used to collect user's login and password.
 */
class LoginForm extends Form
{
    /**
     * Constructor.     
     */
    public function __construct()
    {
        // Define form name
        parent::__construct('login-form');
     
        // Set POST method for this form
        $this->setAttribute('method', 'post');
                
        $this->addElements();
        $this->addInputFilter();          
    }
    
    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() {
                
        // Add "email" field
        $this->add(array(            
            'type'  => 'text',
            'name' => 'email',
            'attributes' => array(
                'id' => 'email'
            ),
            'options' => array(
                'label' => 'Your E-mail',
            ),
        ));
        
        // Add "password" field
        $this->add(array(            
            'type'  => 'password',
            'name' => 'password',
            'attributes' => array(
                'id' => 'password'
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
        
        // Add "remember_me" field
        $this->add(array(            
            'type'  => 'checkbox',
            'name' => 'remember_me',
            'attributes' => array(
                'id' => 'remember_me'
            ),
            'options' => array(
                'label' => 'Remember me',
            ),
        ));
        
        // Add the Submit button
        $this->add(array(
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => array(                
                'value' => 'Sign in',
                'id' => 'submit',
            ),
        ));
        
    }
    
    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() {
        
        // Create main input filter
        $inputFilter = new InputFilter();        
        $this->setInputFilter($inputFilter);
                
        // Add input for "email" field
        $inputFilter->add(array(
                'name'     => 'email',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),                    
                ),                
                'validators' => array(
                    array(
                        'name' => 'EmailAddress',
                        'options' => array(
                            'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
                            'useMxCheck'    => false,                            
                        ),
                    ),
                ),
            )
        );     
        
        // Add input for "password" field
        $inputFilter->add(array(
                'name'     => 'password',
                'required' => true,
                'filters'  => array(                    
                ),                
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 6,
                            'max' => 64
                        ),
                    ),
                ),
            )
        );
        
        // Add input for "remember_me" field
        $inputFilter->add(array(
                'name'     => 'remember_me',
                'required' => true,
                'filters'  => array(                    
                ),                
                'validators' => array(
                    array(
                        'name'    => 'InArray',
                        'options' => array(
                            'haystack' => array(0, 1),                            
                        ),
                    ),
                ),
            )
        );
    }
}
