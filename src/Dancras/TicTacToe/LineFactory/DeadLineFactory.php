<?php

namespace Dancras\TicTacToe\LineFactory;

use Dancras\TicTacToe\Line\DeadLine;
use Dancras\TicTacToe\Line\ILine;
use Dancras\TicTacToe\ValueObject\Coordinate;

class DeadLineFactory
{
    const FQCN = '\Dancras\TicTacToe\LineFactory\DeadLineFactory';

    public function create(ILine $line, Coordinate $i)
    {
        return new DeadLine($this, $line, $i);
    }
}
