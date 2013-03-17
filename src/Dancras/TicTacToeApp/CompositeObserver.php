<?php

namespace Dancras\TicTacToeApp;

use Dancras\TicTacToe\IMoveObserver;
use Dancras\TicTacToe\IWinObserver;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

class CompositeObserver implements IWinObserver, IMoveObserver
{
    const FQCN = '\Dancras\TicTacToeApp\EventBus';

    private $moveObservers = array();

    private $winObservers = array();

    public function whenMovePlayed(Symbol $symbol, Coordinate $x, Coordinate $y)
    {
        foreach ($this->moveObservers as $observer) {
            $observer->whenMovePlayed($symbol, $x, $y);
        }
    }

    public function whenGameIsWon(Symbol $symbol)
    {
        foreach ($this->winObservers as $observer) {
            $observer->whenGameIsWon($symbol);
        }
    }

    public function add($observer)
    {
        if ($observer instanceof IMoveObserver) {
            $this->moveObservers[] = $observer;
        }

        if ($observer instanceof IWinObserver) {
            $this->winObservers[] = $observer;
        }
    }
}
