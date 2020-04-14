#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';

use LivingWorld\Import\Processor\LifeCycle\DependencyInjection\LifeCycleProcessorCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$container = new ContainerBuilder();

$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/config'));
$loader->load('config.yaml');

$application = new Application();
$container->addCompilerPass(new LifeCycleProcessorCompilerPass());
$container->compile();

foreach ($container->findTaggedServiceIds('console.command') as $commandName => $commandDefinition) {
    /** @var Command $command */
    $command = $container->get($commandName);
    $application->add($command);
}

$application->run();
