<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\PostForm;
use Application\Entity\Post;

/**
 * This is the main controller class of the Blog application. The 
 * controller class is used to receive user input, instantiate needed models, 
 * pass the data to the models and pass the results returned by models to the 
 * view for rendering.
 */
class IndexController extends AbstractActionController {
    
    /**
     * This is the default "index" action of the controller. It displays the 
     * Recent Posts page containing the recent blog posts.
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction() {
        
        // Get Doctrine entity manager
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');    	
        
        // Get recent posts
        $recentPosts = $entityManager->getRepository('\Application\Entity\Post')
                ->findBy(array(), array('dateCreated'=>'DESC'), 10);
        
        foreach ($recentPosts as $recentPost) {
            $comments = $recentPost->getComments();
        }
        
        // Render the view template
        return new ViewModel(array(
            'recentPosts' => $recentPosts
        ));
    }
    
    /**
     * This actions displays the "New Post" page. The page contains a form allowing
     * to enter post title, content and tags. When the user clicks the Submit button,
     * a new Post entity will be created.
     */
    public function addAction() {
                
        // Create the form.
        $form = new PostForm();
        
        // Check whether this post is a POST request.
        if($this->getRequest()->isPost()) {
            
            // Get POST data.
            $data = $this->params()->fromPost();
            
            // Fill form with data.
            $form->setData($data);
            if($form->isValid()) {
                                
                // Get validated form data.
                $data = $form->getData();
                
                // Get Doctrine entity manager.
                $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');    	
        
                // Create new Post entity.
                $post = new Post();
                $post->setTitle($data['title']);
                $post->setContent($data['content']);
                $post->setTagsFromString($data['tags']);
                $post->setStatus(Post::STATUS_PUBLISHED);
                
                // Add the entity to entity manager.
                $entityManager->persist($post);
                
                // Apply changes.
                $entityManager->flush();
                
                // Redirect the user to "index" page.
                return $this->redirect()->toRoute('application/default', 
                        array('controller'=>'index', 'action'=>'index'));
            }
        }
        
        // Render the view template.
        return new ViewModel(array(
            'form' => $form
        ));
    }
    
    /**
     * This action displays the About page.
     * @return \Zend\View\Model\ViewModel
     */
    public function aboutAction() {
                
        return new ViewModel();
    }    
}
