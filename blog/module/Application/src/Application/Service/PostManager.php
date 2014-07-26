<?php
namespace Application\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Application\Entity\Post;
use Application\Entity\Comment;
use Application\Entity\Tag;
use Zend\Filter\StaticFilter;

/**
 * The PostManager service is responsible for adding new posts.
 */
class PostManager implements ServiceManagerAwareInterface
{
    /**
     * Service manager.
     * @var Zend\ServiceManager\ServiceManager 
     */
    private $serviceManager = null;
    
    /**
     * Sets service manager.
     * @param Zend\ServiceManager\ServiceManager $serviceManager Service manager.
     */
    public function setServiceManager(ServiceManager $serviceManager) 
    {
        $this->serviceManager = $serviceManager;
    }
    
    /**
     * Returns service manager.
     * @return type
     */
    public function getServiceLocator() 
    {
        return $this->serviceManager;
    }
    
    /**
     * This method adds a new post.
     */
    public function addNewPost($title, $content, $tags) 
    {
        // Get Doctrine entity manager.
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');    	

        // Create new Post entity.
        $post = new Post();
        $post->setTitle($title);
        $post->setContent($content);
        $post->setStatus(Post::STATUS_PUBLISHED);
        $currentDate = date('Y-m-d H:i:s');
        $post->setDateCreated($currentDate);
        $post->setDateModified($currentDate);
        
        // Add the entity to entity manager.
        $entityManager->persist($post);
        
        // Add tags to post
        $tags = explode(',', $tags);
        foreach ($tags as $tagName) {
            
            $tagName = StaticFilter::execute($tagName, 'StringTrim');
            
            $existingTag = $entityManager->getRepository('\Application\Entity\Tag')
                    ->findOneBy(array('name' => $tagName));
            if ($existingTag != null)
                continue;
            
            $tag = new Tag();
            $tag->setName($tagName);
            $tag->addPost($post);
            
            $entityManager->persist($tag);
            
            $post->addTag($tag);
        }
        
        // Apply changes to database.
        $entityManager->flush();
    }
    
    /**
     * 
     * @param type $title
     * @param type $content
     * @param type $tags
     */
    public function updatePost($post, $title, $content, $tags) 
    {
        // Get Doctrine entity manager.
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');    	

        $post->setTitle($title);
        $post->setContent($content);
        
        $currentDate = date('Y-m-d H:i:s');
        $post->setDateModified($currentDate);
        
        // Add tags to post
        $tags = explode(',', $tags);
        foreach ($tags as $tagName) {
            
            $tagName = StaticFilter::execute($tagName, 'StringTrim');
            
            $existingTag = $entityManager->getRepository('\Application\Entity\Tag')
                    ->findOneBy(array('name' => $tagName));
            if ($existingTag != null)
                continue;
            
            $tag = new Tag();
            $tag->setName($tagName);
            $tag->addPost($post);
            
            $entityManager->persist($tag);
            
            $post->addTag($tag);
        }
        
        // Apply changes to database.
        $entityManager->flush();
    }
    
    /**
     * Publishes or unpublishes the post.
     * @param type $isPublished
     */
    public function chanePostStatus($post, $newStatus = Post::STATUS_PUBLISHED) 
    {
        // Get Doctrine entity manager.
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');    	
        
        $post->setStatus($newStatus);
        
        // Apply changes to database.
        $entityManager->flush();
    }

    /**
     * Converts tags to string.
     * @param $post
     */
    public function convertTagsToString($post) 
    {
        $tags = $post->getTags();
        $tagCount = count($tags);
        $tagsStr = '';
        $i = 0;
        foreach ($tags as $tag) {
            $i ++;
            $tagsStr .= $tag->getName();
            if ($i < $tagCount) 
                $tagsStr .= ', ';
        }
        
        return $tagsStr;
    }

    /**
     * Returns post by ID or null if nothing found.
     * @param int $id
     */
    public function findPostById($id) 
    {
        // Get Doctrine entity manager.
        $entityManager = $this->getServiceLocator()
                ->get('doctrine.entitymanager.orm_default');
        
        $post = $entityManager->getRepository('\Application\Entity\Post')
                ->findOneBy(array('id'=>$id));
        
        return $post;
    }

    /**
     * Returns count of comments for given post as properly formatted string.
     * @param $post
     */
    public function getCommentCountStr($post)
    {
        $commentCount = count($post->getComments());
        if ($commentCount == 0)
            return 'No comments';
        else if ($commentCount == 1) 
            return '1 comment';
        else
            return $commentCount . ' comments';
    }


    /**
     * This method adds a new comment to post.
     * @param $post
     * @param $author
     * @param $content
     */
    public function addCommentToPost($post, $author, $content) 
    {
        // Get Doctrine entity manager.
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');    	

        // Create new Comment entity.
        $comment = new Comment();
        $comment->setPost($post);
        $comment->setAuthor($author);
        $comment->setContent($content);
        $comment->setStatus(Comment::STATUS_VISIBLE);
        $currentDate = date('Y-m-d H:i:s');
        $comment->setDateCreated($currentDate);

        // Add the entity to entity manager.
        $entityManager->persist($comment);

        // Apply changes.
        $entityManager->flush();
    }
}



