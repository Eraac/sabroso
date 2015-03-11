<?php

namespace KLS\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PlanningRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PlanningRepository extends EntityRepository
{
    public function nextDays($max, $date = null)
    {
        if (null === $date) {
            $date = new \DateTime();
        }

        $qb = $this->createQueryBuilder('p')
            ->where("p.date >= :date")
            ->setMaxResults($max)
            ->setParameter(":date", $date);

        return $qb->getQuery()->getResult();
    }

    public function previousDays($max)
    {
        $qb = $this->createQueryBuilder('p')
            ->where("p.date < :date")
            ->setMaxResults($max)
            ->setParameter(":date", new \DateTime())
            ->orderBy('p.date', 'DESC');

        return $qb->getQuery()->getResult();
    }
}
