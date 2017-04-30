<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 02/04/17
 * Time: 16:12
 */

namespace SistemaAcesso\AccessControlBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AccessRepository extends EntityRepository
{
    /**
     * @param bool $active
     * @param null $isOut
     * @param bool $isToday
     * @param null $environment
     * @param null $user
     * @param \DateTime|null $dateStart
     * @param \DateTime|null $endDate
     * @return array
     */
    public function findFilter($active = true, $isOut = null, $isToday = true, $environment = null, $user = null, \DateTime $dateStart = null, \DateTime $endDate = null)
    {
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('DATE', 'DoctrineExtensions\Query\Mysql\Date');

        $qb = $this->createQueryBuilder('a');

        $qb
            ->where('a.active = :active')
            ->setParameter('active', $active)
        ;

        if($isOut !== null){
            $qb
                ->andWhere('a.isOut = :isOut')
                ->setParameter('isOut', $isOut)
            ;
        }

        if($isToday){
            $today = new \DateTime('now');
            $qb
                ->andWhere('DATE(a.entryDate) = :today')
                ->setParameter('today', $today->format('Y-m-d'))
            ;
        }

        if(!$isToday and $dateStart){
            $qb
                ->andWhere('DATE(a.entryDate) >= :startDate')
                ->setParameter('startDate', $dateStart->format('Y-m-d'))
            ;
        }

        if(!$isToday and $endDate){
            $qb
                ->andWhere('DATE(a.entryDate) <= :endDate')
                ->setParameter('endDate', $endDate->format('Y-m-d'))
            ;
        }

        if($environment){
            $qb
                ->andWhere('a.environment = :environment')
                ->setParameter('environment', $environment)
            ;
        }

        if($user){
            $qb
                ->andWhere('a.user = :user')
                ->setParameter('user', $user)
            ;
        }

        return $qb
            ->orderBy('a.created', 'ASC')
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true)
            ->getResult();
    }

    /**
     * @param int $limit
     * @return array
     */
    public function findLast($limit = 10){

        $qb = $this->createQueryBuilder('a');

        $qb
            ->where('a.active = :active')
            ->setParameter('active', 1)
        ;

        return $qb
            ->orderBy('a.updated', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true)
            ->getResult();
    }
}