<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="transaction_history")
 */
class TransactionHistory
{
    /**
     * @var \DateTime
     * @ORM\Id
     * @ORM\Column(type="mydatetime", unique=true)
     *
     */
    protected $transactionDate;

    /**
     * @ORM\Column(type="string")
     */
    protected $fromCurrency;

    /**
     * @ORM\Column(type="string")
     */
    protected $toCurrency;

    /**
     * @ORM\Column(type="string")
     */
    protected $fromAmount;

    /**
     * @ORM\Column(type="string")
     */
    protected $toAmount;

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->transactionDate;
    }

    /**
     * @param mixed $date
     * @return TransactionHistory
     */
    public function setDate(\DateTime $date)
    {
        $this->transactionDate = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * @param mixed $transactionDate
     * @return TransactionHistory
     */
    public function setTransactionDate(\DateTime $transactionDate)
    {
        $this->transactionDate = $transactionDate;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getFromCurrency()
    {
        return $this->fromCurrency;
    }

    /**
     * @param mixed $fromCurrency
     * @return TransactionHistory
     */
    public function setFromCurrency($fromCurrency)
    {
        $this->fromCurrency = $fromCurrency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToCurrency()
    {
        return $this->toCurrency;
    }

    /**
     * @param mixed $toCurrency
     * @return TransactionHistory
     */
    public function setToCurrency($toCurrency)
    {
        $this->toCurrency = $toCurrency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFromAmount()
    {
        return $this->fromAmount;
    }

    /**
     * @param mixed $fromAmount
     * @return TransactionHistory
     */
    public function setFromAmount($fromAmount)
    {
        $this->fromAmount = $fromAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToAmount()
    {
        return $this->toAmount;
    }

    /**
     * @param mixed $toAmount
     * @return TransactionHistory
     */
    public function setToAmount($toAmount)
    {
        $this->toAmount = $toAmount;
        return $this;
    }

    public function __toString()
    {
        return $this->getDate() instanceof \DateTime ? $this->getDate()->format("c") : 'new Transaction';
    }
}