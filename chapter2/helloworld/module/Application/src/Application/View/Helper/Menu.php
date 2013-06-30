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
    protected $items;
    
    /**
     *
     * @var type 
     */
    protected $activeItemId = 'home';
    
    /**
     * Constructor.
     * @param array $config
     */
    public function getItems() {
        
        $urlHelper = $this->getView()->url();
        
        $this->items = array(
                    array(
                        'label' => 'Home',
                        'link' => $urlHelper->fromRoute('home', array('controller' => 'index', 'action' => 'index')),
                        'id' => 'home'
                    ),
                    array(
                        'label' => 'About',
                        'link' => 'b',//$controller->url()->fromRoute('about', array('controller' => 'index', 'action' => 'about')),
                        'id' => 'about'
                    ),                    
                );
        
        $viewModel = new ViewModel(
                array('menu' => $this)
               );
        $viewModel->setTemplate('layout/navbar');
        $this->getView()->layout()->addChild($viewModel, 'navbar'); 
        
    }
    
    /**
     * Returns HTML code of the menu.
     * @return string
     */
    public function __toString() {
        return $this->render();
    }
    
    public function setActiveItemId($activeItemId) {
        $this->activeItemId = $activeItemId;
    }
    
    /**
     * Renders the menu.
     * @return string HTML code of the menu.
     */
    public function render($activeItemId='home') {
        
        $result = '<div class="navbar">';
        $result .= '<div class="navbar-inner">';        
        $result .= '<div class="container">';
        $result .= '<div class="nav-collapse collapse">';
        $result .= '<div class="nav">';
        $result .= '<ul class="nav">';
        
        $this->getItems();
        
        foreach($this->items as $item) {
            $result .= $this->renderItem($item, $activeItemId);
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
    protected function renderItem($item, $activeItemId) {
        
        $id = isset($item['id'])?$item['id']:'';
        $isActive = $id==$activeItemId;
        $label = isset($item['label'])?$item['label']:'';
        $link = isset($item['link'])?$item['link']:'#';
        
        $result = $isActive?'<li class="active">':'<li>';
        $result .= '<a href="'.$link.'">'.$label.'</a>';
        $result .= '</li>';
    
        return $result;
    }
    
    
}
