<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class RoleLdap
{
    /** @ORM\Column(type="string") */
    protected $roleName;
    /** @ORM\Column(type="integer") */
    protected $id;

    /**
     * Get id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set RoleName
     * @param string $role
     * @return UserLdap
     */
    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;
        return $this;
    }

    /**
     * Get role
     * @return string
     */
    public function getRoleName()
    {
        return $this->roleName;
    }


    public function __toString()
    {
        return $this->roleName;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add users
     * @param \Yunai39\Bundle\SimpleLdapBundle\Entity\UserLdap $users
     * @return RoleLdap
     */
    public function addUser(\Yunai39\Bundle\SimpleLdapBundle\Entity\UserLdap $users)
    {
        $this->users[] = $users;
        return $this;
    }

    /**
     * Remove users
     * @param \Yunai39\Bundle\SimpleLdapBundle\Entity\UserLdap $users
     */
    public function removeUser(\Yunai39\Bundle\SimpleLdapBundle\Entity\UserLdap $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
