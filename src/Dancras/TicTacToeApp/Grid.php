<?php

namespace Dancras\TicTacToeApp;

use Dancras\TicTacToe\IMoveObserver;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

class Grid implements IMoveObserver
{
    const FQCN = '\Dancras\TicTacToeApp\Grid';

    private $size;
    private $grid = array();

    public function __construct($size)
    {
        $this->size = $size;
    }

    public function whenMovePlayed(Symbol $symbol, Coordinate $x, Coordinate $y)
    {
        $this->grid[$y->getValue()][$x->getValue()] = $symbol->getValue();
    }

    public function getRendered()
    {
        $rows = array();

        for ($i = 0; $i < $this->size; $i++) {
            $rows[] = " {$this->getSymbol($i, 0)} | {$this->getSymbol($i, 1)} | {$this->getSymbol($i, 2)} ";
        }
        
        return join("\n", $rows);
    }

    private function getSymbol($row, $col)
    {
        if (
            !isset($this->grid[$row]) ||
            !isset($this->grid[$row][$col])
        ) {
            return ' ';
        }

        return $this->grid[$row][$col];
    }
}
