<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Translation\TranslatorInterface;
use Yunai39\Bundle\SimpleLdapBundle\Service\LdapService;


class UserLdapProvider implements UserProviderInterface
{

	protected $setting;
	protected $role;
	protected $class;
	
	public function __construct($setting,$role,$class){
		$this->setting = $setting;
		$this->role = $role;
		$this->class = $class;
	}

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     *
     * @see UsernameNotFoundException
     *
     * @throws UsernameNotFoundException if the user is not found
     *
     */
    public function loadUserByUsername($username)
    {
        // The password is set to something impossible to find.
        try {
            $user       = new $this->class($username, uniqid(true) . rand(
                    0,
                    424242
                ), array());
        } catch (\InvalidArgumentException $e) {
            $msg = $this->translator->trans(
                'User invalid',
                array('%reason%' => $e->getMessage())
            );
            throw new UsernameNotFoundException($msg);
        }
        return $user;
    }


    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     * @param UserInterface $user
     *
     * @return UserInterface
     *
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


    public function fetchData( $adUser, TokenInterface $token, LdapService $ldapService)
    {
    	$connected = $ldapService->connect();
        $isAD      = $ldapService->authenticate($adUser->getUsername(), $token->getCredentials());
        if (!$isAD || !$connected) {
            $msg = $this->translator->trans(
                'Mauvaise réponse du serveur: %connexion_status% %is_AD%',
                array(
                    '%connexion_status%' => var_export($connected, 1),
                    '%is_AD%'            => var_export($isAD, 1),
                )
            );
            throw new \Exception(
                $msg
            );
        }
		
		foreach($this->setting as $key => $value){
			$function = 'set'.$key;
			$adUser->$function($ldapService->infoCollection($adUser->getUsername(),$value));
		}
		$role = $ldapService->infoCollection($adUser->getUsername(),'businesscategory');
		if(array_key_exists($role,$this->role)){
        	$adUser->setRoles(array($this->role[$role]));
		}else{
        	$adUser->setRoles(array('ROLE_USER'));
		}
        return true;
    }

    /**
     * Whether this provider supports the given user class
     *
     * @param string $class
     *
     * @return Boolean
     */
    public function supportsClass($class)
    {
        return $class === 'security_ldap_user';
    }
}
