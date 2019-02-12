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
                    ->cannotBeEmpty()
                    ->defaultValue('http://skidata-integration.com/dta')
                ->end()
                ->scalarNode('identifier')
                    ->isRequired()
                ->end()
                ->scalarNode('publicKey')
                    ->isRequired()
                ->end()
                ->arrayNode('endpoints')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('Skidata\Dta\Node\Chip\ValidateChipEndpoint')
                                ->isRequired()
                                ->cannotBeEmpty()
                                ->defaultValue('Skidata\Dta\Feature\CheckValidityOfChipRequest')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
