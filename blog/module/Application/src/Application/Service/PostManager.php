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
    public function addNewPost($title, $content, $tags, $status) 
    {
        // Get Doctrine entity manager.
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');    	

        // Create new Post entity.
        $post = new Post();
        $post->setTitle($title);
        $post->setContent($content);
        $post->setStatus($status);
        $currentDate = date('Y-m-d H:i:s');
        $post->setDateCreated($currentDate);        
        
        // Add the entity to entity manager.
        $entityManager->persist($post);
        
        // Add tags to post
        $tags = explode(',', $tags);
        foreach ($tags as $tagName) {
            
            $tagName = StaticFilter::execute($tagName, 'StringTrim');
            
            $tag = $entityManager->getRepository('\Application\Entity\Tag')
                    ->findOneBy(array('name' => $tagName));
            if ($tag == null)
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
    public function updatePost($post, $title, $content, $tags, $status) 
    {
        // Get Doctrine entity manager.
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');    	

        $post->setTitle($title);
        $post->setContent($content);
        $post->setStatus($status);
        
        // Add tags to post
        $tags = explode(',', $tags);
        foreach ($tags as $tagName) {
            
            $tagName = StaticFilter::execute($tagName, 'StringTrim');
            
            $tag = $entityManager->getRepository('\Application\Entity\Tag')
                    ->findOneBy(array('name' => $tagName));
            if ($tag == null)
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
     * Returns status as a string.
     * @return string 
     */
    public function getPostStatusAsString($post) 
    {
        switch ($post->getStatus()) {
            case Post::STATUS_DRAFT: return 'Draft';
                break;
            case Post::STATUS_PUBLISHED: return 'Published';
                break;
            default: return 'Unknown';
                break;
        }
    }
    
    /**
     * Converts tags of the given post to comma separated list (string).
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
    
    /**
     * Removes post and all associated comments.
     * @param type $post
     */
    public function removePost($post) 
    {
        $entityManager = $this->getServiceLocator()
                ->get('doctrine.entitymanager.orm_default');    	
        
        // Remove associated comments
        $comments = $post->getComments();
        foreach ($comments as $comment) {
            $entityManager->remove($comment);
        }
        
        // Remove tag associations (if any)
        $tags = $post->getTags();
        foreach ($tags as $tag) {
            
            $post->removeTag($tag);
        }
        
        $entityManager->remove($post);
        
        $entityManager->flush();
    }
    
    /**
     * Calculates frequencies of tag usage.
     */
    public function getTagCloud()
    {
        $tagCloud = array();
                
        $entityManager = $this->getServiceLocator()
                ->get('doctrine.entitymanager.orm_default'); 

        $posts = $entityManager->getRepository('\Application\Entity\Post')
                    ->findPostsHavingAnyTag();
        $totalPostCount = count($posts);
        
        $tags = $entityManager->getRepository('\Application\Entity\Tag')
                ->findAll();
        foreach ($tags as $tag) {
            
            $postsByTag = $entityManager->getRepository('\Application\Entity\Post')
                    ->findPostsByTag($tag->getName());
            
            $postCount = count($postsByTag);
            if ($postCount > 0) {
                $tagCloud[$tag->getName()] = $postCount;
            }
        }
        
        $normalizedTagCloud = array();
        
        // Normalize
        foreach ($tagCloud as $name=>$postCount) {
            $normalizedTagCloud[$name] =  $postCount/$totalPostCount;
        }
        
        return $normalizedTagCloud;
    }
}



