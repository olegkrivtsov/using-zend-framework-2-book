<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * This form is used for uploading an image file.
 */
class ImageForm extends Form
{
    /**
     * Constructor.     
     */
    public function __construct()
    {
        // Define form name
        parent::__construct('image-form');
     
        // Set POST method for this form
        $this->setAttribute('method', 'post');
                
        $this->addElements();
        $this->addInputFilter();          
    }
    
    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() {
                
        // Add "file_name" field
        $this->add(array(            
            'type'  => 'text',
            'name' => 'file_name',
            'attributes' => array(
                'id' => 'file_name'
            ),
            'options' => array(
                'label' => 'Save as (optional)',
            ),
        ));
        
        // Add "overwrite_existing" field
        $this->add(array(            
            'type'  => 'checkbox',
            'name' => 'overwrite_existing',
            'attributes' => array(
                'id' => 'overwrite_existing'
            ),
            'options' => array(
                'label' => 'Overwrite if exists',
            ),
        ));
                
        // Add "file" field
        $this->add(array(
            'type'  => 'file',
            'name' => 'file',
            'attributes' => array(                
                'id' => 'file'
            ),
            'options' => array(
                'label' => 'Image file',
            ),
        ));
        
        // Add the submit button
        $this->add(array(
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => array(                
                'value' => 'Submit',
                'id' => 'submitbutton',
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
                'name'     => 'file_name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),                    
                ),                
                'validators' => array(                    
                    array('name' => 'NotEmpty'),                    
                ),
            )
        );
        
        $inputFilter->add(array(
                'name'     => 'overwrite_existing',
                'required' => true,
                'filters'  => array(                    
                ),                
                'validators' => array(                    
                    array(
                        'name' => 'InArray', 
                        'options' => array(0, 1)
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
