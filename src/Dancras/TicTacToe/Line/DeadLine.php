<?php

namespace Dancras\TicTacToe\Line;

use Dancras\Common\Exception\GuardException;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

class DeadLine implements ILine
{
    const FQCN = '\Dancras\TicTacToe\Line\DeadLine';

    private $deadLineFactory;

    private $existingLine;
    private $coordinate;

    public function __construct($deadLineFactory, ILine $line, Coordinate $i)
    {
        $this->deadLineFactory = $deadLineFactory;
        $this->existingLine = $line;
        $this->coordinate = $i;
    }

    public function set(Coordinate $i, Symbol $symbol)
    {
        if ($i->isEqualTo($this->coordinate)) {
            throw new GuardException('Position is occupied');
        }

        $this->existingLine->set($i, $symbol);

        return $this->deadLineFactory->create($this, $i, $symbol);
    }

    public function getNumberOfCoordinates()
    {
        return $this->existingLine->getNumberOfCoordinates() + 1;
    }

    public function getHighestCoordinate()
    {
        return $this->existingLine->getHighestCoordinate();
    }

    public function getSize()
    {
        return $this->existingLine->getSize();
    }
}
