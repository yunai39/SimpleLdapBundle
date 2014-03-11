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
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set RoleName
     *
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
     *
     * @return string 
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

	
	public function __toString(){
		return $this->roleName;
	}
}