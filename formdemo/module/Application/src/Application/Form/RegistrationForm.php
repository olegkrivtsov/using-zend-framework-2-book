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
                    '' => '<select>',
                    1  => 'Mr.',
                    2  => 'Mrs.'
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
        
        // Add "birth_date" field
        $fieldset->add(array(
            'type'  => 'dateselect',
            'name' => 'birth_date',
            'attributes' => array(                
                'id' => 'birth_date'
            ),
            'options' => array(
                'label' => 'Birth Date',
            ),
        ));
        
        // Add the "Address" fieldset
        $fieldset = new Fieldset('address');
        $this->add($fieldset);
        
        // Add "country" field
        $fieldset->add(array(
            'type'  => 'select',
            'name' => 'country',
            'attributes' => array(                
                'id' => 'country'
            ),
            'options' => array(
                'label' => 'Country',
                'value_options' => array(
                    '' => '<select>',
                    1  => 'Australia',
                    2  => 'Brasil',
                    3  => 'Canada',
                    4  => 'China',
                    5  => 'France',
                    6  => 'Japan',
                    7  => 'Korea (South)',
                    8  => 'India',
                    9  => 'Italy',
                    10  => 'United Kingdom',
                    11  => 'United States',                    
                    12 => 'Russia',
                    13 => 'Singapore',
                )
            ),
        ));
        
        // Add "address" field
        $fieldset->add(array(
            'type'  => 'text',
            'name' => 'address',
            'attributes' => array(                
                'id' => 'address'
            ),
            'options' => array(
                'label' => 'Street Address',
            ),
        ));
        
        // Add "city" field
        $fieldset->add(array(
            'type'  => 'text',
            'name' => 'city',
            'attributes' => array(                
                'id' => 'city'
            ),
            'options' => array(
                'label' => 'City',
            ),
        ));
        
        // Add "zip_code" field
        $fieldset->add(array(
            'type'  => 'text',
            'name' => 'zip_code',
            'attributes' => array(                
                'id' => 'zip_code'
            ),
            'options' => array(
                'label' => 'ZIP Code',
            ),
        ));
        
        // Add the submit button
        $this->add(array(
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => array(                
                'value' => 'Create',
                'id' => 'submit',
            ),
        ));
        
        // Add the Cancel button
        $this->add(array(
            'type'  => 'submit',
            'name' => 'cancel',
            'attributes' => array(                
                'value' => 'Cancel',
                'id' => 'cancel',
            ),
        ));
        
    }
    
    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() {
        
        $inputFilter = new InputFilter();        
        $this->setInputFilter($inputFilter);
        
        $fieldsetInputFilter = new InputFilter();
        $inputFilter->add($fieldsetInputFilter, 'personal_info');
        
        $inputFilter->get('personal_info')->add(array(
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
    }
}
