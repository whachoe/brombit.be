<?php
/**
 * Created by PhpStorm.
 * User: cjpa
 * Date: 27/06/2017
 * Time: 17:42
 */

namespace AppBundle\Service;

use AppBundle\Entity\User as UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\VarDumper\VarDumper;

class User
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function recalculatePercentages()
    {
        $userRepo = $this->em->getRepository(UserEntity::class);
        $users = $userRepo->findParticipants();
        $sum = $userRepo->findSumInitialFunds()['totalinitialfunds'];

        /**
         * @var $user User
         */
        foreach ($users as $user) {
            if ($user->isEnabled() && $user->hasRole('ROLE_PARTICIPANT')) {
                $newPercentage = $user->getInitialFunds() * 100/$sum;
                $user->setPercentage($newPercentage);
            }
        }

        $this->em->flush();
    }
}