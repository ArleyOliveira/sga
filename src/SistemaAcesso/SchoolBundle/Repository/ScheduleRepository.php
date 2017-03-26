<?php

namespace SistemaAcesso\SchoolBundle\Repository;


use Doctrine\ORM\EntityRepository;
use SistemaAcesso\SchoolBundle\Entity\Environment;

class ScheduleRepository extends EntityRepository
{
    public function findByEnvironmentSemesterAndWeekDay($environment, $semester, $weekDay)
    {
        $qb = $this->createQueryBuilder('s');

        $qb
            ->where('s.environment = :environment')
            ->setParameter('environment', $environment);

        $qb
            ->andWhere('s.semester = :semester')
            ->setParameter('semester', $semester);

        $qb
            ->andWhere('s.weekDay = :weekDay')
            ->setParameter('weekDay', $weekDay);

        $qb
            ->orderBy('s.weekDay', 'ASC')
            ->orderBy('s.startTime', 'ASC');


        return $qb
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true)
            ->getResult();
    }
}