<?php

declare(strict_types=1);

namespace SkidataBundle\DependencyInjection\Compiler;

use Skidata\Dta\Node\EndpointInterface;
use Skidata\Dta\StrategyInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symplify\PackageBuilder\DependencyInjection\DefinitionCollector;
use Symplify\PackageBuilder\DependencyInjection\DefinitionFinder;

final class CollectEndpointCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $containerBuilder): void
    {
        $definitionCollector = new DefinitionCollector(new DefinitionFinder());
        $definitionCollector->loadCollectorWithType(
            $containerBuilder,
            StrategyInterface::class,
            EndpointInterface::class,
            'addEndpoint'
        );
    }
}
