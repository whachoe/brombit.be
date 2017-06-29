<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findSumInitialFunds()
    {
        $query = $this->getEntityManager()->createQuery(
            "SELECT SUM(u.initialFunds) as totalinitialfunds 
                  FROM AppBundle:User u
                  WHERE u.enabled = TRUE AND u.roles LIKE :role"
        )->setParameter('role', '%ROLE_PARTICIPANT%');

        return $query->getSingleResult();
    }

    public function findParticipants($return_query = false)
    {
        $qb = $this->createQueryBuilder('u');
        $qb ->where("u.enabled = TRUE")
            ->andWhere("u.roles LIKE :role")
            ->setParameter('role', '%ROLE_PARTICIPANT%');
        ;

        if ($return_query)
            return $qb->getQuery();
        else
            return $qb->getQuery()->getResult();
    }
}