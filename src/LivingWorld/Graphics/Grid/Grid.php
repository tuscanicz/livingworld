<?php

declare(strict_types = 1);

namespace LivingWorld\Graphics\Grid;

class Grid
{

    private int $size;

    public function __construct(int $size)
    {
        $this->size = $size;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return array<int, array<int, null>>
     */
    public function getGridWithEmptyRows(): array
    {
        $rows = [];
        for ($x = 0; $x < $this->getSize(); $x++) {
            $columns = [];
            for ($y = 0; $y < $this->getSize(); $y++) {
                $columns[] = null;
            }
            $rows[] = $columns;
        }

        return $rows;
    }

}
