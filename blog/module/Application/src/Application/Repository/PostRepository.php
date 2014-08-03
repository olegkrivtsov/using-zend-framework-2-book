<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

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
        
        $dql = "SELECT p FROM \Application\Entity\Post p JOIN p.tags t WHERE p.status=2 ORDER BY p.dateCreated DESC";    
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
        
        $dql = "SELECT p FROM \Application\Entity\Post p JOIN p.tags t WHERE p.status=2 AND t.name='".$tagName."' ORDER BY p.dateCreated DESC";    
        $query = $entityManager->createQuery($dql);
        $posts = $query->getResult();
        
        return $posts;
    }        
}