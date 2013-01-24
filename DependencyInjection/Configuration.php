<?php
namespace Dtc\SpriteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dtc_sprite');

        $rootNode
            ->children()
                ->arrayNode('sprites')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                        ->scalarNode('path')->isRequired()->end()
                        ->scalarNode('gutter')->defaultValue(10)->end()
                        ->scalarNode('type')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
