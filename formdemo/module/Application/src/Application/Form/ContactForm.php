<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Application\Service\PhoneFilter;
use Application\Service\PhoneValidator;

/**
 * This form is used to collect user feedback data like user E-mail, 
 * message subject and text.
 */
class ContactForm extends Form
{
    /**
     * Constructor.     
     */
    public function __construct()
    {
        // Define form name
        parent::__construct('contact-form');
     
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
        
        // Add "subject" field
        $this->add(array(
            'type'  => 'text',
            'name' => 'subject',
            'attributes' => array(                
                'id' => 'subject'
            ),
            'options' => array(
                'label' => 'Subject',
            ),
        ));
        
        // Add "body" field
        $this->add(array(
            'type'  => 'textarea',
            'name' => 'body',
            'attributes' => array(                
                'id' => 'body'
            ),
            'options' => array(
                'label' => 'Message Body',
            ),
        ));
        
        // Add "phone" field
        $this->add(array(
            'type'  => 'text',
            'name' => 'phone',
            'attributes' => array(                
                'id' => 'phone'
            ),
            'options' => array(
                'label' => 'Your Phone',
            ),
        ));
                
        // Add the CAPTCHA field
        $this->add(array(
            'type'  => 'captcha',
            'name' => 'captcha',
            'attributes' => array(                                                
            ),
            'options' => array(
                'label' => 'Human check',
                'captcha' => array(
                    'class' => 'Image',
                    'imgDir' => './public/img/captcha',
                    'suffix' => '.png',                    
                    'imgUrl' => '/img/captcha/',
                    'imgAlt' => 'CAPTCHA Image',
                    'font'   => './data/font/thorne_shaded.ttf',
                    'fsize'  => 24,
                    'width'  => 350,
                    'height' => 100,
                    'expiration' => 600, 
                    'dotNoiseLevel' => 40,
                    'lineNoiseLevel' => 3
                ),
            ),
        ));
        
        // Add the CAPTCHA field
        /*$this->add(array(
            'type'  => 'captcha',
            'name' => 'captcha',
            'attributes' => array(                                                
            ),
            'options' => array(
                'label' => 'Human check',
                'captcha' => array(
                    'class' => 'Figlet',
                    'wordLen' => 6,
                    'expiration' => 600,                     
                ),
            ),
        ));*/
        
        // Add the CAPTCHA field
        /*$this->add(array(
            'type'  => 'captcha',
            'name' => 'captcha',
            'attributes' => array(                                                
            ),
            'options' => array(
                'label' => 'Human check',
                'captcha' => array(
                    'class' => 'ReCaptcha',
                    'privKey' => '6LfTK-0SAAAAAKh1bxR8X0hLagfexs8UIvfYKsJb',
                    'pubKey' => '6LfTK-0SAAAAANNmfx5Vw-IxoDW_ucUkK2uxdz_k',                     
                ),
            ),
        ));*/
        
        // Add the CSRF field
        $this->add(array(
            'type'  => 'csrf',
            'name' => 'csrf',
            'attributes' => array(                                                
            ),
            'options' => array(                
                'csrf_options' => array(
                     'timeout' => 600
                )
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
        
        $inputFilter->add(array(
                'name'     => 'phone',
                'required' => true,                
                'filters'  => array(                    
                    /*array(
                        'name' => 'Callback',
                        'options' => array(
                            'callback' => array($this, 'filterPhone'),
                            'callbackParams' => array(
                                'form' => $this
                            )
                        )                        
                    ),*/
                    
                    /*array(
                        'name' => '\Application\Service\PhoneFilter',
                        'options' => array(
                            'format' => PhoneFilter::PHONE_FORMAT_INTL
                        )
                    ),*/                    
                ),                
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 3,
                            'max' => 32
                        ),
                    ),
                    /*array(
                        'name' => 'Callback',
                        'options' => array(
                            'callback' => array($this, 'validatePhone'),
                            'callbackOptions' => array(
                                'format' => 'intl'
                            )
                        )                        
                    ),*/
                    array(
                        'name' => '\Application\Service\PhoneValidator',
                        'options' => array(
                            'format' => PhoneValidator::PHONE_FORMAT_INTL
                        )                        
                    ),
                ),
            )
        );
    }
    
    /**
     * Custom filter for a phone number.
     * @param string $value User-entered phone number.
     * @param string $format Desired phone format ('intl' or 'local').
     * @return string Phone number in form of "1 (808) 456-7890" or "123-4567".
     */
    public function filterPhone($value, $format) {
                
        if(!is_scalar($value)) {
            // Return non-scalar value unfiltered.
            return $value;
        }
            
        $value = (string)$value;
        
        if(strlen($value)==0) {
            // Return empty value unfiltered.
            return $value;
        }
        
        // First remove any non-digit character.
        $digits = preg_replace('#[^0-9]#', '', $value);
        
        if($format == 'intl') {
            
            // Pad with zeros if count of digits is incorrect.
            $digits = str_pad($digits, 11, "0", STR_PAD_LEFT);

            // Add the braces, spacing and the dash.
            $phoneNumber = substr($digits, 0, 1) . ' ('. substr($digits, 1, 3) . ') ' .
                            substr($digits, 4, 3) . '-'. substr($digits, 7, 4);
        } else { // 'local'
            // Pad with zeros if count of digits is incorrect.
            $digits = str_pad($digits, 7, "0", STR_PAD_LEFT);

            // Add the the dash.
            $phoneNumber = substr($digits, 0, 3) . '-'. substr($digits, 3, 4);
        }
        
        return $phoneNumber;                  
    }
    
    /**
     * Custom validator for a phone number.
     * @param string $value Phone number in form of "1 (808) 456-7890"
     * @param string $format Phone format ('intl' or 'local').
     * @return boolean true if phone format is correct; otherwise false.
     */
    public function validatePhone($value, $format) {
                
        // Determine the correct length and pattern of the phone number,
        // depending on the format.
        if($format == 'intl') {
            $correctLength = 16;
            $pattern = '/^\d\ (\d{3}\) \d{3}-\d{4}$/';
        } else { // 'local'
            $correctLength = 8;
            $pattern = '/^\d{3}-\d{4}$/';
        }
                
        // Check phone number length.
        if(strlen($value)!=$correctLength)
            return false;

        // Check if the value matches the pattern.
        $matchCount = preg_match($pattern, $value);
        
        return ($matchCount!=0)?true:false;
    }
}
