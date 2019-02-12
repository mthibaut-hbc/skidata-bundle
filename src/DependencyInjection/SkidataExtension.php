<?php

declare(strict_types=1);

namespace SkidataBundle\DependencyInjection;

use Skidata\Dta\RequestBusInterface;
use Skidata\Dta\Security\ConfiguratorInterface;
use Skidata\Dta\Security\EncryptorInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symplify\PackageBuilder\DependencyInjection\DefinitionFinder;

final class SkidataExtension extends Extension implements ExtensionInterface
{
    public function load(array $configs, ContainerBuilder $containerBuilder): void
    {
        $this->loadServices($containerBuilder);

        $configuration = new SkidataConfiguration();
        $configs = $this->processConfiguration($configuration, $configs);

        $this->setupServices($configs, $containerBuilder);
        $this->collectEndpoints($configs, $containerBuilder);
    }

    private function loadServices(ContainerBuilder $containerBuilder): void
    {
        $loader = new XmlFileLoader($containerBuilder, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.xml');
    }

    private function setupServices(array $configs, ContainerBuilder $containerBuilder): void
    {
        $definitionFinder = new DefinitionFinder();

        $configuratorDefinition = $definitionFinder->getByType($containerBuilder, ConfiguratorInterface::class);
        $configuratorDefinition->setArgument(0, $configs['hostname']);
        $configuratorDefinition->setArgument(1, $configs['identifier']);

        $encryptorDefinition = $definitionFinder->getByType($containerBuilder, EncryptorInterface::class);
        $encryptorDefinition->setArgument(0, $configs['publicKey']);
    }

    private function collectEndpoints(array $configs, ContainerBuilder $containerBuilder): void
    {
        $definitionFinder = new DefinitionFinder();
        $requestBusDefinition = $definitionFinder->getByType($containerBuilder, RequestBusInterface::class);

        foreach ($configs['endpoints'] as $endpointClass => $requestClass) {
            $requestBusDefinition->addMethodCall('addEndpoint', [
                $requestClass,
                new Reference($endpointClass)
            ]);
        }
    }
}
