<?php

declare(strict_types=1);

namespace SkidataBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class SkidataConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('skidata');

        $rootNode
            ->children()
                ->scalarNode('hostname')
                    ->defaultValue('http://skidata-integration.com/dta')
                    ->isRequired()
                ->end()
                ->scalarNode('identifier')
                    ->isRequired()
                ->end()
                ->scalarNode('publicKey')
                    ->isRequired()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
