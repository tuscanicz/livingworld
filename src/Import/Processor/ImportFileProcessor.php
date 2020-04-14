<?php

declare(strict_types = 1);

namespace LivingWorld\Import\Processor;

use LivingWorld\Entity\OrganismList;
use LivingWorld\Graphics\Frame\Frame;
use LivingWorld\Import\Processor\LifeCycle\Exception\OrganismWillDieException;
use LivingWorld\Import\Processor\LifeCycle\LifeCycleProcessorInterface;
use LivingWorld\Import\Processor\LifeCycle\Resolve\LifeCycleProcessorResolver;
use LivingWorld\Logger\ImportProcessorLogger;

class ImportFileProcessor
{

    private LifeCycleProcessorResolver $lifeCycleProcessorResolver;
    private ImportProcessorLogger $logger;

    public function __construct(
        LifeCycleProcessorResolver $lifeCycleProcessorResolver,
        ImportProcessorLogger $logger
    ) {
        $this->lifeCycleProcessorResolver = $lifeCycleProcessorResolver;
        $this->logger = $logger;
    }

    public function processFrame(Frame $frame): Frame
    {
        return new Frame(
            $frame->getGrid(),
            $this->processLifeCycle($frame),
            $frame->getRemainingFrames() - 1,
            $frame->getFrameNumber() + 1
        );
    }

    private function processLifeCycle(Frame $frame): OrganismList
    {
        $survivingOrganisms = new OrganismList([]);
        if ($frame->getOrganisms()->hasOrganisms() === true) {
            for ($x = 0; $x < $frame->getGrid()->getSize(); $x++) {
                for ($y = 0; $y < $frame->getGrid()->getSize(); $y++) {
                    $lifeCycleProcessor = $this->lifeCycleProcessorResolver->resolveProcessorByPositionStatus($frame, $x, $y);
                    $survivingOrganisms = $this->getSurvivingOrganism($survivingOrganisms, $lifeCycleProcessor, $frame, $x, $y);
                }
            }
        }

        return $survivingOrganisms;
    }

    private function getSurvivingOrganism(
        OrganismList $survivingOrganismsList,
        LifeCycleProcessorInterface $lifeCycleProcessor,
        Frame $frame,
        int $x,
        int $y
    ): OrganismList {
        $survivingOrganisms = $survivingOrganismsList->getOrganisms();
        try {
            $survivalCandidateOrganisms = $lifeCycleProcessor->getOrganismsForPosition($frame, $x, $y);
            if ($survivalCandidateOrganisms->hasOrganisms() === true) {
                $winningCandidateOrganism = $survivalCandidateOrganisms->getRandomOrganism();
                $this->logger->logBirthOperation('creating a new organism', $x, $y, $frame, $winningCandidateOrganism->getType());
                $survivingOrganisms[] = $winningCandidateOrganism;
            }
        } catch (OrganismWillDieException $e) {
            $this->logger->logDieOperation('dying organism', $x, $y, $e->getNumberOfNeighbours(), $frame, $e->getOrganismType());
        }

        return new OrganismList($survivingOrganisms);
    }

}
