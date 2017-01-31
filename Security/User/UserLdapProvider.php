<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Yunai39\Bundle\SimpleLdapBundle\Service\LdapService;

/**
 * Class UserLdapProvider
 * @package Yunai39\Bundle\SimpleLdapBundle\Security\User
 */
class UserLdapProvider implements UserProviderInterface
{
    /** @var  array */
    protected $setting;

    /** @var string */
    protected $Drole;

    /** @var string */
    protected $class;
    protected $repository;

    public function __construct($setting, $Drole, $class, $repository)
    {
        if ($setting == null) {
            $this->setting = array();
        } else {
            $this->setting = $setting;
        }
        $this->Drole = $Drole;
        $this->class = $class;
        $this->repository = $repository->getRepository("Yunai39\Bundle\SimpleLdapBundle\Entity\UserLdap");
    }

    /**
     * Loads the user for the given username.
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     * @param string $username The username
     * @see UsernameNotFoundException
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        // The password is set to something impossible to find.
        try {
            $user = new $this->class(
                $username,
                uniqid(true) . rand(0, 424242),
                array()
            );
        } catch (\InvalidArgumentException $e) {
            $msg = $this->translator->trans('User invalid', array('%reason%' => $e->getMessage()));
            throw new UsernameNotFoundException($msg);
        }
        return $user;
    }

    /**
     * Refreshes the user for the account interface.
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     * @param UserInterface $user
     * @return UserInterface
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user) {
            $msg = $this->translator->trans(
                'security.ldap.bad_instance'
            );
            throw new UnsupportedUserException($msg);
        }

        return $user;
    }

    /**
     * @param $adUser
     * @param TokenInterface $token
     * @param LdapService $ldapService
     * @return bool
     * @throws \Exception
     */
    public function fetchData($adUser, TokenInterface $token, LdapService $ldapService)
    {
        $connected = $ldapService->connect();
        $isAD = $ldapService->authenticate($adUser->getUsername(), $token->getCredentials());
        if (!$isAD || !$connected) {
            $msg = $this->translator->trans(
                'Mauvaise réponse du serveur: %connexion_status% %is_AD%',
                array(
                    '%connexion_status%' => var_export($connected, 1),
                    '%is_AD%' => var_export($isAD, 1),
                )
            );
            throw new \Exception(
                $msg
            );
        }

        if (count($this->setting) != 0) {
            $info = $ldapService->infoCollection($adUser->getUsername(), $this->setting);
            foreach ($this->setting as $key => $value) {
                $function = 'set' . $key;
                $adUser->$function($info[$value]);
            }
        }
        $user = $this->repository->findBy(array('idLdap' => $adUser->getUsername()));
        if (count($user) != 0) {
            if ($user[0]->getValid()) {
                $tmp = $user[0]->getRoles();
                $roles = array();
                foreach ($tmp as $role) {
                    $roles[] = $role->getRoleName();
                }

                if (count($roles) != 0) {
                    $adUser->setRoles($roles);
                } else {
                    $adUser->setRoles(array($this->Drole));
                }
            } else {
                $adUser->setRoles(array($this->Drole));
            }
        } else {
            $adUser->setRoles(array($this->Drole));
        }

        return true;
    }

    /**
     * Whether this provider supports the given user class
     * @param string $class
     * @return Boolean
     */
    public function supportsClass($class)
    {
        return $class === 'security_ldap_user';
    }
}
