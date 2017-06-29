<?php
/**
 * Created by PhpStorm.
 * User: cjpa
 * Date: 27/06/2017
 * Time: 17:14
 */

namespace AppBundle\Listener;


use AppBundle\AppBundle;
use AppBundle\Service\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


/**
 * Class UserListener
 * @package AppBundle\Listener
 *
 *
 */
class UserListener
{
    /**
     * @var User
     */
    private $userService;

    /**
     * UserListener constructor.
     * @param User $userService
     */
    public function __construct(User $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function postPersist(LifecycleEventArgs $event)
    {
        $this->userService->recalculatePercentages();
    }
}