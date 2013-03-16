<?php

namespace Dancras\TicTacToe\LineMapper;

use Dancras\TicTacToe\Line\EmptyLine;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

class BackDiagonalMapper
{
    const FQCN = '\Dancras\TicTacToe\LineMapper\BackDiagonalMapper';

    private $line;

    public function __construct(EmptyLine $line)
    {
        $this->line = $line;
    }

    public function playMove(Symbol $symbol, Coordinate $x, Coordinate $y)
    {
        if ($x->isEqualTo($y)) {
            $this->line = $this->line->set($x, $symbol);
        }
    }
}
