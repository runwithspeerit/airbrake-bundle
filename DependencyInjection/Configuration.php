<?php

namespace Speerit\AirbrakeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('speerit_airbrake');

        $rootNode
            ->children()
            ->scalarNode('project_id')
            ->isRequired()
            ->end()
            ->scalarNode('project_key')
            ->isRequired()
            ->end()
            ->scalarNode('host')
            ->defaultValue('api.airbrake.io')
            ->end()
            ->arrayNode('ignored_exceptions')
            ->prototype('scalar')->end()
            ->defaultValue(['Symfony\Component\HttpKernel\Exception\HttpException'])
            ->end()
            ->end();

        return $treeBuilder;
    }
}
