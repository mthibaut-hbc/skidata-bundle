<?php

declare(strict_types=1);

namespace SkidataBundle;

use SkidataBundle\DependencyInjection\Compiler\CollectEndpointCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SkidataBundle extends Bundle
{
    public function build(ContainerBuilder $containerBuilder): void
    {
        parent::build($containerBuilder);

        $containerBuilder->addCompilerPass(new CollectEndpointCompilerPass());
    }
}
