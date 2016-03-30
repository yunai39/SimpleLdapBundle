<?php

namespace Yunai39\Bundle\SimpleLdapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('simple_ldap');

        $rootNode
            ->children()
                ->arrayNode('settings')
                    ->children()
                        ->scalarNode('server')->isRequired()->end()
                        ->scalarNode('port')->isRequired()->end()
                        ->scalarNode('account_suffix')->isRequired()->end()
                        ->arrayNode('base_dn')
                            ->useAttributeAsKey('name')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('settings_user')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('user_redirects')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('user_class')->isRequired()->end()
                ->scalarNode('default_role')->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}
