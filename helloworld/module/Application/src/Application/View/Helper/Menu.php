<?php

namespace Application\View\Helper;

use Zend\View\AbstractHelper;

/**
 * This view helper class displays a menu bar.
 * 
 */
class Menu extends \Zend\View\Helper\AbstractHelper {
 
    /**
     * Menu items array.
     * @var array 
     */
    protected $items = array();
    
    /**
     * Active item's ID.
     * @var string  
     */
    protected $activeItemId = '';
    
    /**
     * Constructor.
     * @param array $items Menu items.
     */
    public function __construct($items=array()) {
        $this->items = $items;
    }
    
    /**
     * Sets menu items.
     * @param array $items Menu items.
     */
    public function setItems($items) {
        $this->items = $items;
    }
    
    /**
     * Sets ID of the active items.
     * @param string $activeItemId
     */
    public function setActiveItemId($activeItemId) {
        $this->activeItemId = $activeItemId;
    }
    
    /**
     * Renders the menu.
     * @return string HTML code of the menu.
     */
    public function render() {
        
        if(count($this->items)==0)
            return ''; // Do nothing if there are no items.
        
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
     * @param array $item The menu item info.
     * @return string HTML code of the item.
     */
    protected function renderItem($item) {
        
        $id = isset($item['id']) ? $item['id'] : '';
        $isActive = ($id==$this->activeItemId);
        $label = isset($item['label']) ? $item['label'] : '';
        $link = isset($item['link']) ? $item['link'] : '#';
        
        $result = $isActive?'<li class="active">':'<li>';
        $result .= '<a href="'.$link.'">'.$label.'</a>';
        $result .= '</li>';
    
        return $result;
    }
    
    
}
