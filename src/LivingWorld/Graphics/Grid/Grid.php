<?php

namespace LivingWorld\Graphics\Grid;

class Grid
{
    private $size;

    public function __construct($size)
    {
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getRows()
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
