<?php

declare(strict_types=1);

namespace SkidataBundle\DependencyInjection;

use Skidata\Dta\Security\ConfiguratorInterface;
use Skidata\Dta\Security\EncryptorInterface;
use Symfony\Bundle\FrameworkBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symplify\PackageBuilder\DependencyInjection\DefinitionFinder;

final class SkidataExtension extends Extension implements ExtensionInterface
{
    public function load(array $configs, ContainerBuilder $containerBuilder): void
    {
        $this->loadServices($containerBuilder);
        $this->setupServices($configs, $containerBuilder);
    }

    private function loadServices(ContainerBuilder $containerBuilder): void
    {
        $loader = new XmlFileLoader($containerBuilder, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.xml');
    }

    private function setupServices(array $configs, ContainerBuilder $containerBuilder): void
    {
        $config = $this->processConfiguration(
            new Configuration(false),
            $configs
        );

        $finder = new DefinitionFinder();

        $configurator = $finder->getByType($containerBuilder, ConfiguratorInterface::class);
        $configurator->setArgument(0, $config['skidata']['hostname']);
        $configurator->setArgument(1, $config['skidata']['identifier']);

        $encryptor = $finder->getByType($containerBuilder, EncryptorInterface::class);
        $encryptor->setArgument(0, $config['skidata']['publicKey']);
    }
}
