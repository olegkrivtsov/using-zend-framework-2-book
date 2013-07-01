<?php

namespace Application\View\Helper;

use Zend\View\AbstractHelper;

/**
 * This class displays menu bar.
 * 
 */
class Menu extends \Zend\View\Helper\AbstractHelper {
 
    /**
     * Menu items.
     * @var array 
     */
    protected $items = array();
    
    /**
     * Active item's ID.
     * @var type 
     */
    protected $activeItemId = '';
    
    /**
     * Constructor.
     */
    public function __construct($items=array()) {
        $this->items = $items;
    }
    
    /**
     * Sets menu items.
     * @param type $items
     */
    public function setItems($items) {
        $this->items = $items;
    }
    
    /**
     * 
     * @param type $activeItemId
     */
    public function setActiveItemId($activeItemId) {
        $this->activeItemId = $activeItemId;
    }
    
    /**
     * Renders the menu.
     * @return string HTML code of the menu.
     */
    public function render() {
        
        $result = '<div class="navbar">';
        $result .= '<div class="navbar-inner">';        
        $result .= '<div class="container">';
        $result .= '<div class="nav-collapse collapse">';
        $result .= '<div class="nav">';
        $result .= '<ul class="nav">';
        
        foreach($this->items as $item) {
            $result .= $this->renderItem($item);
        }
        
        $result .= '</ul>';
        $result .= '</div>';
        $result .= '</div>';
        $result .= '</div>';
        $result .= '</div>';
        $result .= '</div>';
        
        return $result;
        
    }
    
    /**
     * Renders an item.
     * @param array $item
     * @return string HTML code of the item.
     */
    protected function renderItem($item) {
        
        $id = isset($item['id'])?$item['id']:'';
        $isActive = $id==$this->activeItemId;
        $label = isset($item['label'])?$item['label']:'';
        $link = isset($item['link'])?$item['link']:'#';
        
        $result = $isActive?'<li class="active">':'<li>';
        $result .= '<a href="'.$link.'">'.$label.'</a>';
        $result .= '</li>';
    
        return $result;
    }
    
    
}
