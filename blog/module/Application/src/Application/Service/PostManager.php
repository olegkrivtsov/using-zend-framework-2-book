<?php
namespace Application\Service;

/**
 * The PostManager service is responsible for adding new posts.
 */
class PostManager 
{
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
        $post->setTagsFromString($tags);
        $post->setStatus(Post::STATUS_PUBLISHED);

        // Add the entity to entity manager.
        $entityManager->persist($post);

        // Apply changes.
        $entityManager->flush();
    }
    
}
