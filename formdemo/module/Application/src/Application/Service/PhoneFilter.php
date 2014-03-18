<?php
namespace Application\Service;
use Zend\Filter\AbstractFilter;

class PhoneFilter extends AbstractFilter {
    
    const PHONE_FORMAT_LOCAL = 1; // Local phone format "333-7777"
    const PHONE_FORMAT_INTL  = 2; // International phone format "1 (123) 456-7890"    
    
    private $format = self::PHONE_FORMAT_INTL;
    
    /**
     * 
     * @param type $options
     */
    public function setOptions($options) {
        parent::setOptions($options);
        
        
    }
    
    /**
     * Filters a phone number.
     * @param string $value User-entered phone number.
     * @return string Phone number in form of "1 (808) 456-7890"
     */
    public function filterPhone($value, $form) {
                
        if(strlen($value)==0)
            return $value;
        
        // First remove any non-digit character.
        $digits = preg_replace('#[^0-9]#', '', $value);
        
        // Pad with zeros if count of digits is incorrect.
        $digits = str_pad($digits, 11, "0", STR_PAD_LEFT);
        
        // Add the braces, spacing and the dash.
        $phoneNumber = substr($digits, 0, 1) . ' ('. substr($digits, 1, 3) . ') ' .
                        substr($digits, 4, 3) . '-'. substr($digits, 7, 4);
        
        return $phoneNumber;                
    }
    
}
