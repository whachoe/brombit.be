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
     * @var \DateTime
     * @ORM\Id
     * @ORM\Column(type="mydatetime", unique=true)
     */
    protected $balanceDate;

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
        return $this->balanceDate;
    }

    /**
     * @param mixed $date
     * @return Balance
     */
    public function setDate(\DateTime $date)
    {
        $this->balanceDate = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBalanceDate()
    {
        return $this->balanceDate;
    }

    /**
     * @param mixed $balanceDate
     * @return Balance
     */
    public function setBalanceDate(\DateTime $balanceDate)
    {
        $this->balanceDate = $balanceDate;
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

    public function __toString()
    {
        return $this->getDate() ? $this->getDate()->format("c") : 'new Balance';
    }
}