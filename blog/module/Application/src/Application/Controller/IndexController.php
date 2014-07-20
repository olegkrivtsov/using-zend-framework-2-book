<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * This is the main controller class of the Blog application. The 
 * controller class is used to receive user input, instantiate needed models, 
 * pass the data to the models and pass the results returned by models to the 
 * view for rendering. This main controller contains site-wide actions like
 * "index" or "about".
 */
class IndexController extends AbstractActionController 
{
    /**
     * This is the default "index" action of the controller. It displays the 
     * Recent Posts page containing the recent blog posts.
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() 
    {
        
        // Get Doctrine entity manager
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');    	
        
        // Get recent posts
        $recentPosts = $entityManager->getRepository('\Application\Entity\Post')
                ->findBy(array(), array('dateCreated'=>'DESC'), 10);
        
        // Render the view template
        return new ViewModel(array(
            'recentPosts' => $recentPosts
        ));
    }
    
    /**
     * This action displays the About page.
     * @return \Zend\View\Model\ViewModel
     */
    public function aboutAction() 
    {
                
        return new ViewModel();
    }    
}
