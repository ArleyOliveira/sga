<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 13/11/16
 * Time: 01:46
 */

namespace SistemaAcesso\SchoolBundle\Repository;


use Doctrine\ORM\EntityRepository;

class CourseRepository extends EntityRepository
{
    /**
     * @param bool $active
     * @param null $name
     * @param null $knowledgeArea
     * @return array
     */
    public function findFilter($active = true, $name = null, $knowledgeArea = null)
    {
        $qb = $this->createQueryBuilder('c');

        $qb
            ->where('c.active = :active')
            ->setParameter('active', $active);

        if ($name) {
            $qb
                ->andWhere($qb->expr()->like('c.name', ':name'))
                ->setParameter('name', "%{$name}%");
        }

        if ($knowledgeArea) {
            $qb
                ->andWhere('c.knowledgeArea = :knowledgeArea')
                ->setParameter('knowledgeArea', $knowledgeArea);
        }

        return $qb
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true)
            ->getResult();
    }
}