<?php

namespace Icse\MembersBundle\Entity;

/**
 * MembershipProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MembershipProductRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCurrent(\DateTime $dt = null)
    {
        if ($dt === null) $dt = new \DateTime;

        return $this->getEntityManager()
            ->createQuery ('
                SELECT p
                FROM IcseMembersBundle:MembershipProduct p
                WHERE p.starts_at <= :now
                AND   p.ends_at >= :now
            ')
            ->setParameters(['now' => $dt])
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}
