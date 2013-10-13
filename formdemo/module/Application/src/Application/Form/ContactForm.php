<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * This form is used to collect user feedback data like user E-mail, 
 * message subject and text.
 */
class ContactForm extends \Zend\Form\Form
{
    /**
     * Constructor.     
     */
    public function __construct()
    {
        // Define form name
        parent::__construct('contact-form');
     
        $this->addElements();
        $this->addInputFilter();
    }
    
    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() {
        
        // Set POST method for this form
        $this->setAttribute('method', 'post');
        
        // Add "email" field
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Your E-mail',
            ),
        ));
        
        // Add "subject" field
        $this->add(array(
            'name' => 'subject',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Subject',
            ),
        ));
        
        // Add "body" field
        $this->add(array(
            'name' => 'body',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Message Body',
            ),
        ));
        
        // Add the submit button
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Submit',
                'id' => 'submitbutton',
            ),
        ));
    }
    
    /**
     * This method creates input filter (used for form validation).
     */
    private function addInputFilter() {
        
        $inputFilter = new InputFilter();        
        $this->setInputFilter($inputFilter);
        
        $factory = new InputFactory();
        
        $inputFilter->add($factory->createInput(array(
                'name'     => 'email',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),                    
                ),                
                'validators' => array(
                    array(
                        'name'    => 'EmailAddress',
                        'options' => array(
                            'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
                            'useMxCheck'    => false,                            
                        ),
                    ),
                ),
            )
        ));
        
        $inputFilter->add($factory->createInput(array(
                'name'     => 'subject',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                    array('name' => 'StripNewLines'),
                ),                
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 128
                        ),
                    ),
                ),
            )
        ));
        
        $inputFilter->add($factory->createInput(array(
                'name'     => 'subject',
                'required' => true,
                'filters'  => array(                    
                    array('name' => 'StripTags'),
                ),                
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 4096
                        ),
                    ),
                ),
            )
        ));
    }
}
