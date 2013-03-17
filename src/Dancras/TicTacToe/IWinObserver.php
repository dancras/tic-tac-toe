<?php

namespace Dancras\TicTacToe;

use Dancras\TicTacToe\ValueObject\Symbol;

interface IWinObserver
{
    public function whenGameIsWon(Symbol $symbol);
}
