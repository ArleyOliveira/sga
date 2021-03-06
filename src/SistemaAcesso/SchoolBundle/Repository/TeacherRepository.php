<?php


namespace SistemaAcesso\SchoolBundle\Repository;


use Doctrine\ORM\EntityRepository;

class TeacherRepository extends EntityRepository
{
    /**
     * @param bool $active
     * @param null $description
     * @return array
     */
    public function findFilter($active = true, $description = null)
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
                    $qb->expr()->eq('p.siape', '?2'),
                    $qb->expr()->like('p.cellphone', '?3'),
                    $qb->expr()->like('p.email', '?4')
                )
            );
            $qb
                ->setParameter("1", "%{$description}%")
                ->setParameter("2", "{$description}")
                ->setParameter("3", "%{$description}%")
                ->setParameter("4", "%{$description}%")
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