<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * This form is used to collect comment data.
 */
class CommentForm extends Form
{
    /**
     * Constructor.     
     */
    public function __construct()
    {
        // Define form name
        parent::__construct('comment-form');
     
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
        // Add "author" field
        $this->add(array(            
            'type'  => 'text',
            'name' => 'author',
            'attributes' => array(
                'id' => 'author'
            ),
            'options' => array(
                'label' => 'Author',
            ),
        ));
        
        // Add "comment" field
        $this->add(array(            
            'type'  => 'textarea',
            'name' => 'comment',
            'attributes' => array(
                'id' => 'comment'
            ),
            'options' => array(
                'label' => 'Comment',
            ),
        ));
                
        // Add the submit button
        $this->add(array(
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => array(                
                'value' => 'Save',
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
                'name'     => 'author',
                'required' => true,
                'filters'  => array(                    
                    array('name' => 'StringTrim'),
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
                'name'     => 'comment',
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

