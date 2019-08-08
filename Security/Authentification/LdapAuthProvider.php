<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Security\Authentification;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Yunai39\Bundle\SimpleLdapBundle\Service\LdapService;
use Yunai39\Bundle\SimpleLdapBundle\Security\User\UserLdapProvider;

/**
 * Class LdapAuthProvider
 * @package Yunai39\Bundle\SimpleLdapBundle\Security\Authentification
 */
class LdapAuthProvider implements AuthenticationProviderInterface
{
    /**
     * @var \Yunai39\Bundle\SimpleLdapBundle\Security\User\UserLdapProvider
     */
    private $userProvider;
    private $LdapService;

    /**
     * LdapAuthProvider constructor.
     * @param UserLdapProvider $userProvider
     * @param LdapService $LdapService
     */
    public function __construct(UserLdapProvider $userProvider, LdapService $LdapService)
    {
        $this->userProvider = $userProvider;
        $this->LdapService = $LdapService;
    }

    /**
     * Attempts to authenticates a TokenInterface object.
     * @param TokenInterface $token The TokenInterface instance to authenticate
     * @return TokenInterface An authenticated TokenInterface instance, never null
     * @throws AuthenticationException if the authentication fails
     * @throws BadCredentialsException if the authentication fails
     */
    public function authenticate(TokenInterface $token)
    {
        $User = $this->userProvider->loadUserByUsername($token->getUsername());
        if ($User) {
            if (!$this->LdapService->authenticate($User->getUsername(), $token->getCredentials())) {
                $msg = 'security.ldap.wrong_credential';
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
     * @param TokenInterface $token A TokenInterface instance
     * @return Boolean true if the implementation supports the Token, false otherwise
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof UsernamePasswordToken;
    }
}
