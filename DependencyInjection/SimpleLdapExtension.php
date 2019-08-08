<?php

namespace Yunai39\Bundle\SimpleLdapBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class SimpleLdapExtension
 * @package Yunai39\Bundle\SimpleLdapBundle\DependencyInjection
 */
class SimpleLdapExtension extends Extension
{

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $container->setParameter('simple_ldap.settings', $config['settings']);
        $container->setParameter('simple_ldap.settings_user', $config['settings_user']);
        $container->setParameter('simple_ldap.user_redirects', $config['user_redirects']);
        $container->setParameter('simple_ldap.user_class', $config['user_class']);
        $container->setParameter('simple_ldap.default_role', $config['default_role']);
    }
}
