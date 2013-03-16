<?php

namespace Dancras\TicTacToe\Line;

use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

interface ILine
{
    public function set(Coordinate $i, Symbol $symbol);

    public function getNumberOfCoordinates();

    public function getHighestCoordinate();

    public function getSize();
}
