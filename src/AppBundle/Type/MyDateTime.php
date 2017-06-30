<?php
namespace AppBundle\Type;

class MyDateTime extends \DateTime
{
    public function __toString()
    {
        return $this->format('c');
    }
}