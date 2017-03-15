#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Console\Application;

// @todo: wiring should be done better :)
$randomOrganismTypeGetter = new \LivingWorld\Generate\XmlFile\Structure\Organism\RandomOrganismTypeGetter();
$worldStructureGenerator = new \LivingWorld\Generate\XmlFile\WorldStructureGenerator($randomOrganismTypeGetter);
$xmlFileGetter = new \LivingWorld\Generate\XmlFile\XmlFileGetter();
$xmlFileSaver = new \LivingWorld\Generate\XmlFile\XmlFileSaver(__DIR__.'/../tmp');
$xmlFileParser = new \LivingWorld\Import\XmlFile\XmlFileParser(__DIR__.'/../tmp');
$organismTypeFormatter = new \LivingWorld\Graphics\OrganismTypeFormatter();
$organismOutputFormatter = new \LivingWorld\Graphics\OrganismOutputFormatter();
$screenWriter = new \LivingWorld\Graphics\Screen\ScreenWriter($organismTypeFormatter);
$importFileProcessor = new \LivingWorld\Import\Processor\ImportFileProcessor();
$worldStructureGetter = new \LivingWorld\Import\XmlFile\Output\WorldStructureGetter();

$application = new Application();
$application->add(
    new \LivingWorld\Import\ImportCommand(
        $organismOutputFormatter,
        $xmlFileParser,
        $importFileProcessor,
        $worldStructureGetter,
        $xmlFileGetter,
        $xmlFileSaver,
        $screenWriter
    )
);
$application->add(
    new \LivingWorld\Generate\GenerateWorldCommand(
        $worldStructureGenerator,
        $xmlFileGetter,
        $xmlFileSaver
    )
);

$application->run();
