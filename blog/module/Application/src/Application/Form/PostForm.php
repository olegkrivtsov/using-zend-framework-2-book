<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * This form is used to collect post data.
 */
class PostForm extends Form
{
    /**
     * Constructor.     
     */
    public function __construct()
    {
        // Define form name
        parent::__construct('post-form');
     
        // Set POST method for this form
        $this->setAttribute('method', 'post');
                
        $this->addElements();
        $this->addInputFilter();  
        
    }
    
    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() 
    {
                
        // Add "title" field
        $this->add(array(            
            'type'  => 'text',
            'name' => 'title',
            'attributes' => array(
                'id' => 'title'
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
        
        // Add "content" field
        $this->add(array(
            'type'  => 'textarea',
            'name' => 'content',
            'attributes' => array(                
                'id' => 'content'
            ),
            'options' => array(
                'label' => 'Content',
            ),
        ));
        
        // Add "tags" field
        $this->add(array(
            'type'  => 'text',
            'name' => 'tags',
            'attributes' => array(                
                'id' => 'tags'
            ),
            'options' => array(
                'label' => 'Tags',
            ),
        ));
        
        // Add the submit button
        $this->add(array(
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => array(                
                'value' => 'Create',
                'id' => 'submitbutton',
            ),
        ));
    }
    
    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() 
    {
        
        $inputFilter = new InputFilter();        
        $this->setInputFilter($inputFilter);
        
        $inputFilter->add(array(
                'name'     => 'title',
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
                            'max' => 1024
                        ),
                    ),
                ),
            )
        );
        
        $inputFilter->add(array(
                'name'     => 'content',
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
        
        $inputFilter->add(array(
                'name'     => 'tags',
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
                            'max' => 1024
                        ),
                    ),
                ),
            )
        );
    }
}

