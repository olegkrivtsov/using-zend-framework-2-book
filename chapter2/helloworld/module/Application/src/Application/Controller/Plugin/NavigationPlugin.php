<?php
namespace Application\Controller\Plugin;
 
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\ViewModel;
use Application\View\Helper\Menu; 
use Application\View\Helper\Breadcrumbs; 

/**
 * This controller plugin is used to provide navigation menu and breadcrumbs
 * to all controllers in the application.
 */
class NavigationPlugin extends AbstractPlugin{
    
    /**
     * Adds the 'menu' variable to layout view model.
     * @return \Application\View\Helper\Menu
     */
    public function addMenu($activeItemId = 'home') {
        
        return;
        $controller = $this->getController();
        
        $menu = new \Application\View\Helper\Menu(array(
                'items' => array(
                    array(
                        'label' => 'Home',
                        'link' => $controller->url()->fromRoute('home', array('controller' => 'index', 'action' => 'index')),
                        'active' => $activeItemId=='home'?true:false
                    ),
                    array(
                        'label' => 'About',
                        'link' => $controller->url()->fromRoute('about', array('controller' => 'index', 'action' => 'about')),
                        'active' => $activeItemId=='about'?true:false
                    ),                    
                )                
            )
        );
        
        $viewModel = new ViewModel(
                array('menu' => $menu)
               );
        $viewModel->setTemplate('layout/navbar');
        $controller->layout()->addChild($viewModel, 'navbar');        
    }
    
    /**
     * Adds the 'breadcrumbs' to layout view model.
     * @param type $activeItemId
     */
    public function addBreadcrumbs($items) {
        
        $controller = $this->getController();
        
        $breadcrumbs = new \Application\View\Helper\Breadcrumbs(array('items'=>$items));
        
        $viewModel = new ViewModel(
                array('breadcrumbs' => $breadcrumbs)
               );
        $viewModel->setTemplate('layout/breadcrumbs');
        $controller->layout()->addChild($viewModel, 'breadcrumbs');        
    }
}