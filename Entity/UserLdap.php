<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\MappedSuperclass
 */
abstract class UserLdap
{

    /** @ORM\Column(type="integer") */
    protected $id;


    /** @ORM\Column(type="string") */
    protected $idLdap;

    /** @ORM\Column(type="string") */
    protected $role;
	
    /** @ORM\Column(type="boolean") */
    protected $valid;

	
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idLdap
     *
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
     *
     * @return string 
     */
    public function getIdLdap()
    {
        return $this->idLdap;
    }

    /**
     * Set Role
     *
     * @param string $role
     * @return UserLdap
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }
	
    /**
     * Set valid
     *
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
     *
     * @return boolean 
     */
    public function getValid()
    {
        return $this->valid;
    }
	

}