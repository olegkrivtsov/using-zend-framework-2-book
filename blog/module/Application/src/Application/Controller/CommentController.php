<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\CommentForm;
use Application\Entity\Post;

/**
 * This is the Post controller class of the Blog application. 
 * This controller is used for managing comments (adding/editing/viewing/deleting).
 */
class CommentController extends AbstractActionController 
{
    /**
     * This actions displays the "New Comment" page. The page contains a form allowing
     * to enter comment. When the user clicks the Submit button,
     * a new Comment entity will be created.
     */
    public function addAction() 
    {
                
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
}
