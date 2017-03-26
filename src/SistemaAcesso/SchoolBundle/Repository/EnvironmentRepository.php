<?php


namespace SistemaAcesso\SchoolBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EnvironmentRepository extends EntityRepository
{
    /**
     * @param bool $active
     * @param null $name
     * @return array
     */
    public function findFilter($active = true, $name = null)
    {
        $qb = $this->createQueryBuilder('e');

        $qb
            ->where('e.active = :active')
            ->setParameter('active', $active);

        if ($name) {
            $qb
                ->andWhere($qb->expr()->like('e.name', ':name'))
                ->setParameter('name', "%{$name}%");
        }

        return $qb
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true)
            ->getResult();
    }
}