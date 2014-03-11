<?php
/**
 * 
 */
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * The ImageForm form model is used for uploading an image file.
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
        
        // Set binary content encoding
        $form->setAttribute('enctype', 'multipart/form-data');  
        
        $this->addElements();
        $this->addInputFilter();          
    }
    
    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() {
        
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
                
        // Add "file-name" field
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
        
        // Add "overwrite-existing" field
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
        
        // Add validation rules for the "file" field	 
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
        
        // Add validation rules for the "file-name" field	 
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
        
        // Add validation rules for the "overwrite-existing" field	 
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
        
    }
}
