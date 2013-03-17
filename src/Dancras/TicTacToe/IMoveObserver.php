<?php

namespace Dancras\TicTacToe;

use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

interface IMoveObserver
{
    public function whenMovePlayed(Symbol $symbol, Coordinate $x, Coordinate $y);
}
