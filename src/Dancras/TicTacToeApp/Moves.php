<?php

namespace Dancras\TicTacToeApp;

use Dancras\TicTacToe\Game;
use Dancras\TicTacToe\IMoveObserver;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

class Moves implements IMoveObserver
{
    const FQCN = '\Dancras\TicTacToeApp\Moves';

    public function __construct()
    {
        if (
            !isset($_SESSION['ticTacToeApp']['moves']) ||
            !is_array($_SESSION['ticTacToeApp']['moves'])
        ) {
            $this->clearMoves();
        }
    }

    public function whenMovePlayed(Symbol $symbol, Coordinate $x, Coordinate $y)
    {
        $_SESSION['ticTacToeApp']['moves'][] = array($symbol->getValue(), $x->getValue(), $y->getValue());
    }

    public function replayMoves(Game $game)
    {
        foreach ($_SESSION['ticTacToeApp']['moves'] as $move) {
            $game->playMove(
                new Symbol($move[0]),
                new Coordinate($move[1]),
                new Coordinate($move[2])
            );
        }
    }

    public function clearMoves()
    {
        $_SESSION['ticTacToeApp']['moves'] = array();
    }
}
