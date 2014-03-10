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
            'name' => 'file-name',
            'attributes' => array(
                'id' => 'file-name'
            ),
            'options' => array(
                'label' => 'Save as (optional)',
            ),
        ));
        
        // Add "overwrite_existing" field
        $this->add(array(            
            'type'  => 'checkbox',
            'name' => 'overwrite-existing',
            'attributes' => array(
                'id' => 'overwrite-existing'
            ),
            'options' => array(
                'label' => 'Overwrite if such file already exists',
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
                'name'     => 'file-name',
                'required' => true,
                'allow_empty' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),                    
                ),                
                'validators' => array(                    
                    array('name' => 'NotEmpty'),                    
                ),
            )
        );
        
        $inputFilter->add(array(
                'name'     => 'overwrite-existing',
                'required' => true,
                'allow_empty' => true,
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
                'type'     => 'Zend\InputFilter\FileInput',
                'name'     => 'file',
                'required' => true,
                'filters'  => array(                    
                    
                ),                
                'validators' => array(
                    array(
                        'name'    => 'FileIsImage',                        
                    ),
                    array(
                        'name'    => 'FileImageSize',                        
                        'options' => array(                            
                            'minWidth'  => 128,
                            'minHeight' => 128,
                            'maxWidth'  => 4096,
                            'maxHeight' => 4096
                        )
                    ),
                ),
            )
        );                
    }
}
