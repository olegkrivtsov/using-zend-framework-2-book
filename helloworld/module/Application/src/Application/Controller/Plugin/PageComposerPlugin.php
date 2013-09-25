<?php
namespace Admin\Controller\Plugin;

use \Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\ViewModel;

class PageComposerPlugin extends AbstractPlugin {
    
    public function composePage() {
        
        $sidebarViewModel = new ViewModel(array(            
        ));
        $sidebarViewModel->setTemplate('application/index/sidebar');
        
        $this->getController()->layout()->addChild($childViewModel, 'sidebar');
    }
}