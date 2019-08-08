<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserLdap
 * @package Yunai39\Bundle\SimpleLdapBundle\Security\User
 */
class UserLdap implements UserInterface
{
    /** @var string */
    private $username;

    /** @var string */
    private $fullname;

    /** @var string */
    private $password;

    /** @var string */
    private $salt;

    /** @var array */
    private $roles;

    /**
     * UserLdap constructor.
     * @param string $username
     * @param string $password
     * @param array $roles
     */
    public function __construct($username, $password, array $roles)
    {
        $this->username = $username;
        $this->password = $password;
        $this->salt = '';
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullname;
    }

    /**
     * @param string $fullname
     */
    public function setFullName($fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * Returns the password used to authenticate the user.
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     * This can return null if the password was not encoded using a salt.
     * @return string The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Removes sensitive data from the user.
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     * @return void
     */
    public function eraseCredentials()
    {
        //return void;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }
}
