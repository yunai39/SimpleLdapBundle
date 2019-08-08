<?php

namespace Yunai39\Bundle\SimpleLdapBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Yunai39\Bundle\SimpleLdapBundle\Security\Factory\LdapAuthFactory;

/**
 * Class SimpleLdapBundle
 * @package Yunai39\Bundle\SimpleLdapBundle
 */
class SimpleLdapBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new LdapAuthFactory());
    }
}
