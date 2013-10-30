<?php

namespace Security\LdapBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Security\LdapBundle\Security\Factory\LdapAuthFactory;

class SecurityLdapBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new LdapAuthFactory());
    }
}
