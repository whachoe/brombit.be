<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\Identifier;
use AppBundle\Entity\Traits\MetaData;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 *
 */
class User extends BaseUser
{
    use MetaData;

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $ethAddress;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $initialFunds;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    protected $percentage;



    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getEthAddress()
    {
        return $this->ethAddress;
    }

    /**
     * @param mixed $ethAddress
     * @return User
     */
    public function setEthAddress($ethAddress)
    {
        $this->ethAddress = $ethAddress;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInitialFunds()
    {
        return $this->initialFunds;
    }

    /**
     * @param mixed $initialFunds
     * @return User
     */
    public function setInitialFunds($initialFunds)
    {
        $this->initialFunds = $initialFunds;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @param mixed $percentage
     * @return User
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
        return $this;
    }

}