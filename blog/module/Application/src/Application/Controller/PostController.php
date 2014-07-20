<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\PostForm;
use Application\Entity\Post;

/**
 * This is the Post controller class of the Blog application. 
 * This controller is used for managing posts (adding/editing/viewing/deleting).
 */
class PostController extends AbstractActionController 
{
    /**
     * This actions displays the "New Post" page. The page contains a form allowing
     * to enter post title, content and tags. When the user clicks the Submit button,
     * a new Post entity will be created.
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
                
                // Use post manager service to add new post to database.
                $postManager = $this->getServiceLocator()->get('post_manager');
                $postManager->addNewPost($data['title'], $data['content'], 
                        $data['tags']);
                
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
