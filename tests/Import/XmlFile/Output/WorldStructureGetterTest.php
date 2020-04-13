<?php

declare(strict_types = 1);

namespace LivingWorld\Import\XmlFile\Output;

use LivingWorld\Entity\Organism as EntityOrganism;
use LivingWorld\Entity\OrganismList as EntityOrganismList;
use LivingWorld\Enum\OrganismTypeEnum;
use LivingWorld\Generate\XmlFile\Structure\Organism\Organism as XmlOrganism;
use LivingWorld\Generate\XmlFile\Structure\Organism\OrganismList as XmlOrganismList;
use LivingWorld\Generate\XmlFile\Structure\WorldStructure;
use LivingWorld\Graphics\Frame\Frame;
use LivingWorld\Graphics\Grid\Grid;
use PHPUnit\Framework\TestCase;

class WorldStructureGetterTest extends TestCase
{

    private WorldStructureGetter $worldStructureGetter;

    public function setUp(): void
    {
        $this->worldStructureGetter = new WorldStructureGetter();
    }

    /**
     * @param Frame $frame
     * @param WorldStructure $expectedWorldStructure
     * @dataProvider provideFramesAndStructures
     */
    public function testGetWordStructureFromFrame(Frame $frame, WorldStructure $expectedWorldStructure): void
    {
        $actualWorldStructure = $this->worldStructureGetter->getWordStructureFromFrame($frame);

        self::assertEquals($expectedWorldStructure, $actualWorldStructure);
    }

    /**
     * @return array<int, array<int, Frame|WorldStructure>>
     */
    public function provideFramesAndStructures(): array
    {
        return [
            [
                new Frame(new Grid(100), new EntityOrganismList([]), 3, 2),
                new WorldStructure(100, 0, 2, new XmlOrganismList([])),
            ],
            [
                new Frame(
                    new Grid(10),
                    new EntityOrganismList([
                        new EntityOrganism(0, 0, new OrganismTypeEnum(OrganismTypeEnum::TYPE_ATREIDES)),
                        new EntityOrganism(1, 2, new OrganismTypeEnum(OrganismTypeEnum::TYPE_ATREIDES)),
                        new EntityOrganism(2, 3, new OrganismTypeEnum(OrganismTypeEnum::TYPE_ATREIDES)),
                    ]),
                    1,
                    1
                ),
                new WorldStructure(
                    10,
                    3,
                    1,
                    new XmlOrganismList([
                        new XmlOrganism(0, 0, new OrganismTypeEnum(OrganismTypeEnum::TYPE_ATREIDES)),
                        new XmlOrganism(1, 2, new OrganismTypeEnum(OrganismTypeEnum::TYPE_ATREIDES)),
                        new XmlOrganism(2, 3, new OrganismTypeEnum(OrganismTypeEnum::TYPE_ATREIDES)),
                    ])
                ),
            ],
        ];
    }

}
