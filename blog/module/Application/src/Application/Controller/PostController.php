<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\PostForm;
use Application\Entity\Post;
use Application\Form\CommentForm;
use Application\Entity\Comment;

/**
 * This is the Post controller class of the Blog application. 
 * This controller is used for managing posts (adding/editing/viewing/deleting).
 */
class PostController extends AbstractActionController 
{
    /**
     * This action displays the "New Post" page. The page contains a form allowing
     * to enter post title, content and tags. When the user clicks the Submit button,
     * a new Post entity will be created.
     */
    public function addAction() 
    {     
        // Create the form.
        $form = new PostForm();
        
        $postManager = $this->getServiceLocator()->get('post_manager');
        
        // Check whether this post is a POST request.
        if ($this->getRequest()->isPost()) {
            
            // Get POST data.
            $data = $this->params()->fromPost();
            
            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {
                                
                // Get validated form data.
                $data = $form->getData();
                
                // Use post manager service to add new post to database.                
                $postManager->addNewPost($data['title'], $data['content'], 
                        $data['tags'], $data['status']);
                
                // Redirect the user to "index" page.
                return $this->redirect()->toRoute('application/default', 
                        array('controller'=>'index', 'action'=>'index'));
            }
        }
        
        // Render the view template.
        return new ViewModel(array(
            'form' => $form,
            'postManager' => $postManager
        ));
    }    
    
    /**
     * This action displays the "View Post" page allowing to see the post title
     * and content. The page also contains a form allowing
     * to add a comment to post. 
     */
    public function viewAction() 
    {       
        $postId = $this->params()->fromRoute('id', -1);
        
        $postManager = $this->getServiceLocator()->get('post_manager');        
        $post = $postManager->findPostById($postId);        
        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;                        
        }        
        
        $commentCount = $postManager->getCommentCountStr($post);
        
        // Create the form.
        $form = new CommentForm();
        
        // Check whether this post is a POST request.
        if($this->getRequest()->isPost()) {
            
            // Get POST data.
            $data = $this->params()->fromPost();
            
            // Fill form with data.
            $form->setData($data);
            if($form->isValid()) {
                                
                // Get validated form data.
                $data = $form->getData();
                
                // Use post manager service to add new comment to post.
                $postManager->addCommentToPost(
                        $post, $data['author'], $data['comment']);
                
                // Redirect the user again to "view" page.
                return $this->redirect()->toRoute('application/default', 
                        array('controller'=>'post', 'action'=>'view', 'id'=>$postId));
            }
        }
        
        // Render the view template.
        return new ViewModel(array(
            'post' => $post,
            'commentCount' => $commentCount,
            'form' => $form,
            'postManager' => $postManager
        ));
    }  
    
    /**
     * This action displays the page allowing to edit a post.
     * @return \Zend\View\Model\ViewModel
     */
    public function editAction() 
    {
        $form = new PostForm();
        
        $postId = $this->params()->fromRoute('id', -1);
        
        $postManager = $this->getServiceLocator()->get('post_manager');        
        $post = $postManager->findPostById($postId);        
        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;                        
        } 
        
        // Check whether this post is a POST request.
        if ($this->getRequest()->isPost()) {
            
            // Get POST data.
            $data = $this->params()->fromPost();
            
            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {
                                
                // Get validated form data.
                $data = $form->getData();
                
                // Use post manager service to add new post to database.                
                $postManager->updatePost($post, $data['title'], $data['content'], 
                        $data['tags'], $data['status']);
                
                // Redirect the user to "index" page.
                return $this->redirect()->toRoute('application/default', 
                        array('controller'=>'index', 'action'=>'index'));
            }
        } else {
            $data = array(
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'tags' => $postManager->convertTagsToString($post),
                'status' => $post->getStatus()
            );
            
            $form->setData($data);
        }
        
        // Render the view template.
        return new ViewModel(array(
            'form' => $form,
            'post' => $post
        ));  
    }
    
    /**
     * This "delete" action displays the Delete Post page.
     * @return \Zend\View\Model\ViewModel
     */
    public function deleteAction()
    {
        $postId = $this->params()->fromRoute('id', -1);
        
        $entityManager = $this->getServiceLocator()
                ->get('doctrine.entitymanager.orm_default');    	
        
        $post = $entityManager->getRepository('\Application\Entity\Post')
                ->findOneBy(array('id'=>$postId));        
        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;                        
        }        
        
        $postManager = $this->getServiceLocator()->get('post_manager');  
        $postManager->removePost($post);
        
        // Redirect the user to "index" page.
        return $this->redirect()->toRoute('application/default', 
                array('controller'=>'post', 'action'=>'admin'));
        
        // Render the view template.
        return new ViewModel(array(
        ));        
    }
    
    /**
     * This "admin" action displays the Manage Posts page. This page contains
     * the list of posts with an ability to publish/unpublish/edit/delete any post.
     * @return \Zend\View\Model\ViewModel
     */
    public function adminAction()
    {
        // Get Doctrine entity manager
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');    	
        
        $postManager = $this->getServiceLocator()->get('post_manager');     
        
        // Get recent posts
        $posts = $entityManager->getRepository('\Application\Entity\Post')
                ->findBy(array(), array('dateCreated'=>'DESC'));
        
        // Render the view template
        return new ViewModel(array(
            'posts' => $posts,
            'postManager' => $postManager
        ));        
    }
}
