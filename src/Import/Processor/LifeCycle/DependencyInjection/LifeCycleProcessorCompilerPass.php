<?php

declare(strict_types = 1);

namespace LivingWorld\Import\Processor\LifeCycle\DependencyInjection;

use LivingWorld\Import\Processor\LifeCycle\Resolve\LifeCycleProcessorStorage;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class LifeCycleProcessorCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $containerBuilder): void
    {
        $lifeCycleProcessorStorageDefinition = $containerBuilder->getDefinition(LifeCycleProcessorStorage::class);
        foreach ($containerBuilder->findTaggedServiceIds('lifecycle.processor') as $name => $definition) {
            $lifeCycleProcessorStorageDefinition->addMethodCall('addLifeCycleProcessor', [new Reference($name)]);
        }
    }

}
