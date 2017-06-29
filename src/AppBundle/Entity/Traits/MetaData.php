<?php
namespace AppBundle\Entity\Traits;


use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

trait MetaData
{
    use TimestampableEntity;

    /**
     * @var \DateTime
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User")
     */
    private $createdBy;

    /**
     * @var \DateTime
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User")
     */
    private $updatedBy;

    /**
     * Set createdBy
     *
     * @param User $createdBy
     *
     * @return \DateTime
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param User  $updatedBy
     *
     * @return \DateTime
     */
    public function setUpdatedBy(User $updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
}