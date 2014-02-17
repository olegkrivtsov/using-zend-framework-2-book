<?php
/**
 * 
 */       
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;

/**
 * This form is used to collect user's personal information, address, and 
 * payment preferences.
 */
class RegistrationForm extends Form
{
    /**
     * Constructor.     
     */
    public function __construct()
    {
        // Define form name
        parent::__construct('registration-form');
     
        // Set POST method for this form
        $this->setAttribute('method', 'post');
                
        $this->addElements();
        $this->addInputFilter();          
    }
    
    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() {
        
        $fieldset = new Fieldset('personal_info');
        $this->add($fieldset);
                
        // Add "email" field
        $fieldset->add(array(            
            'type'  => 'text',
            'name' => 'email',
            'attributes' => array(
                'id' => 'email'
            ),
            'options' => array(
                'label' => 'Your E-mail',
            ),
        ));
        
        // Add "title" field
        $fieldset->add(array(
            'type'  => 'select',
            'name' => 'title',
            'attributes' => array(                
                'id' => 'title'
            ),
            'options' => array(
                'label' => 'Title',
                'value_options' => array(
                    0 => '<select>',
                    1 => 'Mr.',
                    2 => 'Mrs.'
                )
            ),
        ));
        
        // Add "first_name" field
        $fieldset->add(array(
            'type'  => 'text',
            'name' => 'first_name',
            'attributes' => array(                
                'id' => 'first_name'
            ),
            'options' => array(
                'label' => 'First Name',
            ),
        ));
        
        // Add "last_name" field
        $fieldset->add(array(
            'type'  => 'text',
            'name' => 'last_name',
            'attributes' => array(                
                'id' => 'last_name'
            ),
            'options' => array(
                'label' => 'Last Name',
            ),
        ));
        
        
        // Add the submit button
        $fieldset->add(array(
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => array(                
                'value' => 'Create',
                'id' => 'submit',
            ),
        ));
        
        
    }
    
    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() {
        
        $inputFilter = new InputFilter();        
        $this->setInputFilter($inputFilter);
        
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
        
        $inputFilter->add(array(
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
        );
        
        $inputFilter->add(array(
                'name'     => 'body',
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
        );                
    }
}
