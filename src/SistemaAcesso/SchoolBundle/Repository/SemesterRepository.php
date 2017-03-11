<?php


namespace SistemaAcesso\SchoolBundle\Repository;


use Doctrine\ORM\EntityRepository;
use SistemaAcesso\SchoolBundle\Entity\Semester;

class SemesterRepository extends EntityRepository
{
    /**
     * @param bool $active
     * @param null $year
     * @param null|int $semester
     * @return array
     */
    public function findFilter($active = true, $year = null, $semester = null)
    {
        $qb = $this->createQueryBuilder('s');

        $qb
            ->where('s.active = :active')
            ->setParameter('active', $active);

        if ($year) {
            $qb
                ->andWhere('s.year = :year')
                ->setParameter('year', $year);
        }

        if ($semester) {
            $qb
                ->andWhere('s.semester = :semester')
                ->setParameter('semester', $semester);
        }

        return $qb
            ->orderBy('s.year', 'DESC')
            ->orderBy('s.semester', 'DESC')
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true)
            ->getResult();
    }
}