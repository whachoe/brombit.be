<?php
namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Identifier {
    /**
    * @var int
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}