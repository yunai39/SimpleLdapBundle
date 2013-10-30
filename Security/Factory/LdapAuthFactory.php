<?php

namespace Yunai39\Bundle\SimpleLdapBundle\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\FormLoginFactory;

class LdapAuthFactory extends FormLoginFactory
{



    /**
     * Subclasses must return the id of a service which implements the
     * AuthenticationProviderInterface.
     *
     * @param ContainerBuilder $container
     * @param string $id             The unique id of the firewall
     * @param array $config         The options array for this listener
     * @param string $userProviderId The id of the user provider
     *
     * @return string never null, the id of the authentication provider
     */
    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {

        $providerId = 'security.authentication.provider.ldap.' . $id;
        $container
            ->setDefinition(
                $providerId,
                new DefinitionDecorator('security_authentification_provider')
            )
            ->replaceArgument(0, new Reference("security_ldap_provider"));
        //exit();
        return $providerId;
    }

    /*public function getListenerId(){
        return
    }*/

    public function getKey()
    {
        return 'ldap';
    }
}
