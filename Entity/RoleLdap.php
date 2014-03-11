<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\MappedSuperclass
 */
abstract class RoleLdap
{
    /** @ORM\Column(type="string") */
    protected $roleName;
	

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

	

}