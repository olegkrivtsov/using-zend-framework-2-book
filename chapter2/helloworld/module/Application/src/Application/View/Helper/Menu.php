<?php

namespace Application\View\Helper;

/**
 * This class displays menu bar.
 * 
 */
class Menu {
 
    /**
     * Menu items.
     * @var array 
     */
    protected $items;
    
    /**
     * Constructor.
     * @param array $config
     */
    public function __construct($config) {
        
        if(isset($config['items'])) {
            $this->items = $config['items'];
        } else {
            throw new \Exception('No items specified');
        }
        
    }
    
    /**
     * Returns HTML code of the menu.
     * @return string
     */
    public function __toString() {
        return $this->render();
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
        
        $isActive = isset($item['active'])?$item['active']:false;
        $label = isset($item['label'])?$item['label']:'';
        $link = isset($item['link'])?$item['link']:'#';
        
        $result = $isActive?'<li class="active">':'<li>';
        $result .= '<a href="'.$link.'">'.$label.'</a>';
        $result .= '</li>';
    
        return $result;
    }
    
    
}
