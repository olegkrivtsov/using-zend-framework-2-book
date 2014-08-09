<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Post;

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
        $tagFilter = $this->params()->fromQuery('tag', null);
        
        // Get Doctrine entity manager
        $entityManager = $this->getServiceLocator()
                ->get('doctrine.entitymanager.orm_default');    	
        
        if ($tagFilter) {
         
            // Filter posts by tag
            $posts = $entityManager->getRepository('\Application\Entity\Post')
                    ->findPostsByTag($tagFilter);
            
        } else {
            // Get recent posts
            $posts = $entityManager->getRepository('\Application\Entity\Post')
                    ->findBy(array('status'=>Post::STATUS_PUBLISHED), 
                             array('dateCreated'=>'DESC'));
        }
        
        // Get post manager service.
        $postManager = $this->getServiceLocator()->get('post_manager');  
        
        // Get popular tags.
        $tagCloud = $postManager->getTagCloud();
        
        // Render the view template.
        return new ViewModel(array(
            'posts' => $posts,
            'postManager' => $postManager,
            'tagCloud' => $tagCloud
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
