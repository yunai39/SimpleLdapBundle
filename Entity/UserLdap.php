<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserInfo
 */
class UserLdap
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $idLdap;

    /**
     * @var string
     */
    private $role;
	
    /**
     * @var boolean
     */
    private $valid;

	
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
    public function setIdLdap($matricule)
    {
        $this->matricule = $matricule;
    
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