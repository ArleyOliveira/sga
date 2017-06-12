<?php


namespace SistemaAcesso\UserBundle\Repository;


use Doctrine\ORM\EntityRepository;

class PersonRepository extends EntityRepository
{
    /**
     * @param bool $active
     * @param null $description
     * @return array
     */
    public function findFilter($active = true, $description = null, $activity = null)
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->where('p.active = :active')
            ->setParameter('active', $active);

        if ($description) {
            $qb
                ->andWhere(
                    $qb
                        ->expr()->orX(
                            $qb->expr()->like('p.name', '?1'),
                            $qb->expr()->like('p.cellphone', '?3'),
                            $qb->expr()->like('p.email', '?4')
                        )
                );
            $qb
                ->setParameter("1", "%{$description}%")
                ->setParameter("3", "%{$description}%")
                ->setParameter("4", "%{$description}%")
            ;
        }

        if($activity){
            $qb
                ->andWhere('p.activity = :activity')
                ->setParameter('activity', $activity)
            ;
        }

        return $qb
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true)
            ->getResult();
    }
}