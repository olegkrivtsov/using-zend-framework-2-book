<?php

namespace Application\View\Helper;

use Zend\View\AbstractHelper;

/**
 * This view helper class displays a form row.
 * 
 */
class CustomFormRow extends \Zend\View\Helper\AbstractHelper {
 
    /**
     * 
     * @param type $element
     * @param type $attrs
     * @return type
     */
    public function __invoke($element, $attrs = null) {
        
        return $this->render($element, $attrs);
    }
    
    /**
     * 
     * @param type $element
     * @param type $attrs
     */
    public function render($element, $attrs = null) {
        
        $result = '';
        
        $result .= '<div class="form-group">';
        $result .= $this->formLabel($element);
        $result .= $this->formText($element);
        $result .= $this->formElementErrors($element);
        $result .= '</div>';
        
        return $result;
    }
}
