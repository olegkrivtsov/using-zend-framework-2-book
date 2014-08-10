<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Application\Entity\Post;

/**
 * This is the custom repository class for Post entity.
 */
class PostRepository extends EntityRepository
{
    /**
     * Finds all published posts having any tag.
     * @return type
     */
    public function findPostsHavingAnyTag()
    {
        $entityManager = $this->getEntityManager();
        
        $dql = "SELECT p FROM \Application\Entity\Post p JOIN p.tags t WHERE p.status=".Post::STATUS_PUBLISHED." ORDER BY p.dateCreated DESC";    
        $query = $entityManager->createQuery($dql);
        $posts = $query->getResult();
        
        return $posts;
    }
    
    /**
     * Finds all published posts having the given tag.
     * @param string $tagName Name of the tag.
     * @return type
     */
    public function findPostsByTag($tagName)
    {
        $entityManager = $this->getEntityManager();
        
        $dql = "SELECT p FROM \Application\Entity\Post p JOIN p.tags t WHERE p.status=".Post::STATUS_PUBLISHED." AND t.name='".$tagName."' ORDER BY p.dateCreated DESC";    
        $query = $entityManager->createQuery($dql);
        $posts = $query->getResult();
        
        return $posts;
    }        
}