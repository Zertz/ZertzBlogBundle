<?php
namespace Zertz\Blog\PostBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function findByPublished($limit, $offset)
    {
        return $this->getEntityManager()->getRepository('ZertzBlogPostBundle:Post')->createQueryBuilder('p')
            ->select('p')
            /*->addSelect('s')
            ->addSelect('t')
            ->leftJoin('ZertzBlogPostBundle:PostSource', 'ps', 'WITH', 'p.id = ps.post')
            ->leftJoin('ZertzBlogPostBundle:Source', 's', 'WITH', 's.id = ps.source')
            ->leftJoin('ZertzBlogPostBundle:PostTag', 'pt', 'WITH', 'p.id = pt.post')
            ->leftJoin('ZertzSortBundle:Tag', 't', 'WITH', 't.id = pt.tag')*/
            ->where('p.published = TRUE')
            ->orderBy('p.publishedAt', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findOneByPublishedAndSlug($slug)
    {
        return $this->getEntityManager()->getRepository('ZertzBlogPostBundle:Post')->createQueryBuilder('p')
            ->select('p')
            ->where('p.published = TRUE AND p.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getSingleResult();
    }
    
    public function countAllPublished()
    {
        return $this->getEntityManager()->getRepository('ZertzBlogPostBundle:Post')->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
