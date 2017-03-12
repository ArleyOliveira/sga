<?php

namespace SistemaAcesso\SchoolBundle\Repository;


use Doctrine\ORM\EntityRepository;
use SistemaAcesso\SchoolBundle\Entity\Course;

class DisciplineRepository extends EntityRepository
{
    /**
     * @param bool $active
     * @param null $name
     * @param null|Course $course
     * @return array
     */
    public function findFilter($active = true, $name = null, $course = null)
    {
        $qb = $this->createQueryBuilder('d');

        $qb
            ->where('d.active = :active')
            ->setParameter('active', $active);

        if ($name) {
            $qb
                ->andWhere($qb->expr()->orX(
                    $qb->expr()->like('d.name', ':name'),
                    $qb->expr()->like('d.sigla', ':name')
                ))
                ->setParameter('name', "%{$name}%");
        }

        if ($course) {
            $qb
                ->andWhere('d.course = :course')
                ->setParameter('course', $course->getId());
        }

        return $qb
            ->orderBy('d.name', 'ASC')
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true)
            ->getResult();
    }
}