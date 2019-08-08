<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class UserLdap
{
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

    /** @ORM\Column(type="string") */
    protected $idLdap;

    /** @ORM\Column(type="boolean") */
    protected $valid;

    /**
     * @ORM\ManyToMany(targetEntity="Yunai39\Bundle\SimpleLdapBundle\Entity\RoleLdap", cascade={"persist"})
     */
    protected $roles;

    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set idLdap
     * @param string $idLdap
     * @return UserLdap
     */
    public function setIdLdap($idLdap)
    {
        $this->idLdap = $idLdap;

        return $this;
    }

    /**
     * Get idLdap
     * @return string
     */
    public function getIdLdap()
    {
        return $this->idLdap;
    }

    /**
     * Set valid
     * @param boolean $valid
     * @return UserInfo
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     * @return boolean
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Add roles
     * @param \Yunai39\Bundle\SimpleLdapBundle\Entity\RoleLdap $role
     */
    public function addRole(\Yunai39\Bundle\SimpleLdapBundle\Entity\RoleLdap $role)
    {
        $this->roles[] = $role;
    }

    /**
     * Remove roles
     * @param \Yunai39\Bundle\SimpleLdapBundle\Entity\RoleLdap $role
     */
    public function removeRole(\Yunai39\Bundle\SimpleLdapBundle\Entity\RoleLdap $role)
    {
        $this->roles->removeElement($role);
    }

    /**
     * Get roles
     * @return Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->idLdap;
    }
}
