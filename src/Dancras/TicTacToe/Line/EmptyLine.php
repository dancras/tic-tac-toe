<?php

namespace Dancras\TicTacToe\Line;

use Dancras\Common\Exception\GuardException;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

class EmptyLine implements ILine
{
    const FQCN = '\Dancras\TicTacToe\Line\EmptyLine';

    private $winningLineFactory;

    public function __construct($winningLineFactory)
    {
        $this->winningLineFactory = $winningLineFactory;
    }

    public function set(Coordinate $i, Symbol $symbol)
    {
        if ($i->getValue() > 2) {
            throw new GuardException('Coordinate must be less than 2');
        }

        return $this->winningLineFactory->create($this, $i, $symbol);
    }

    public function getNumberOfCoordinates()
    {
        return 0;
    }

    public function getHighestCoordinate()
    {
        return 2;
    }

    public function getSize()
    {
        return 3;
    }
}
