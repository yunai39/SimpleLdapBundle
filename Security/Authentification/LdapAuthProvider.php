<?php

namespace Security\LdapBundle\Security\Authentification;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Security\LdapBundle\Security\User\UserLdapProvider;
use Security\LdapBundle\Security\User\UserLdap;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Security\LdapBundle\Service\LdapService;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class LdapAuthProvider implements AuthenticationProviderInterface
{

    /**
     * @var \Security\LdapBundle\Security\User\UserLdapProvider
     */
    private $userProvider;
	private $LdapService;
	

    public function __construct(UserLdapProvider $userProvider, 
        LdapService $LdapService  ) {
        $this->userProvider  = $userProvider;
        $this->LdapService = $LdapService;
    }

    /**
     * Attempts to authenticates a TokenInterface object.
     *
     * @param TokenInterface $token The TokenInterface instance to authenticate
     *
     * @return TokenInterface An authenticated TokenInterface instance, never null
     *
     * @throws AuthenticationException if the authentication fails
     */
    public function authenticate(TokenInterface $token)
    {
        $User   = $this->userProvider->loadUserByUsername($token->getUsername());
        if ($User instanceof UserLdap) {
            if (!$this->LdapService->authenticate($User->getUsername(), $token->getCredentials())) {
                $msg =  'security.ldap.wrong_credential';
                throw new BadCredentialsException($msg);
            }
            $this->userProvider->fetchData($User, $token, $this->LdapService);
        }

        $newToken = new UsernamePasswordToken(
            $User,
            $token->getCredentials(),
            "security_ldap_provider",
            $User->getRoles()
        );

        return $newToken;
    }

    /**
     * Checks whether this provider supports the given token.
     *
     * @param TokenInterface $token A TokenInterface instance
     *
     * @return Boolean true if the implementation supports the Token, false otherwise
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof UsernamePasswordToken;
    }
}
