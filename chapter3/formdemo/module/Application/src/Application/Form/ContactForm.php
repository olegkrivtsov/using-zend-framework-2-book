<?php

namespace Application\Form;

use Zend\Form\Form;

/**
 * This form is used to collect user feedback data like user E-mail, 
 * message subject and text.
 */
class ContactForm extends \Zend\Form\Form
{
    /**
     * Constructor.
     * @param string $name Form name.
     */
    public function __construct($name = null)
    {
        // Define form name
        parent::__construct('contact-form');
        
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
        
        // Add image captcha
        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Human check',
                'captcha' => array(
                    'class' => 'Image',
                    'imgDir' => './public/img',
                    'imgUrl' => 'img',
                    'font' => '/home/devel/share/using-zend-framework-2-book/chapter3/formdemo/data/fonts/arial.ttf',
                    'width' => 250,
                    'height' => 100,
                    'dotNoiseLevel' => 40,
                    'lineNoiseLevel' => 3
                ),
            ),            
        ));
        
        // Add figlet captcha
        /*$this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Human check',
                'captcha' => array(
                    'class' => 'Figlet',
                    'worldLen' => 5                    
                ),
            ),            
        ));*/        
        
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
}

