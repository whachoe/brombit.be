<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="balance")
 *
 */
class Balance
{
    /**
     * @ORM\Id
     * @ORM\Column(type="datetime", unique=true)
     */
    protected $date;

    /**
     * @ORM\Column(type="string")
     */
    protected $btc;

    /**
     * @ORM\Column(type="string")
     */
    protected $eth;

    /**
     * @ORM\Column(type="string")
     */
    protected $ltc;

    /**
     * @ORM\Column(type="string")
     */
    protected $zec;

    /**
     * @ORM\Column(type="string")
     */
    protected $totalEuro;

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return Balance
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBtc()
    {
        return $this->btc;
    }

    /**
     * @param mixed $btc
     * @return Balance
     */
    public function setBtc($btc)
    {
        $this->btc = $btc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEth()
    {
        return $this->eth;
    }

    /**
     * @param mixed $eth
     * @return Balance
     */
    public function setEth($eth)
    {
        $this->eth = $eth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLtc()
    {
        return $this->ltc;
    }

    /**
     * @param mixed $ltc
     * @return Balance
     */
    public function setLtc($ltc)
    {
        $this->ltc = $ltc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZec()
    {
        return $this->zec;
    }

    /**
     * @param mixed $zce
     * @return Balance
     */
    public function setZec($zec)
    {
        $this->zec = $zec;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalEuro()
    {
        return $this->totalEuro;
    }

    /**
     * @param mixed $totalEuro
     * @return Balance
     */
    public function setTotalEuro($totalEuro)
    {
        $this->totalEuro = $totalEuro;
        return $this;
    }
}