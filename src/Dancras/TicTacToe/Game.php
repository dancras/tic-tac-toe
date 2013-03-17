<?php

namespace Dancras\TicTacToe;

use Dancras\Common\Exception\GuardException;
use Dancras\TicTacToe\IMoveObserver;
use Dancras\TicTacToe\LineMapper\BackDiagonalMapper;
use Dancras\TicTacToe\LineMapper\ForwardDiagonalMapper;
use Dancras\TicTacToe\LineMapper\HorizontalMapper;
use Dancras\TicTacToe\LineMapper\VerticalMapper;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

class Game
{
    const FQCN = '\Dancras\TicTacToe\Game';

    private $mappers = array();

    private $moveObserver;

    private $lastSymbol;

    public function __construct(
        BackDiagonalMapper $backDiagonalMapper,
        ForwardDiagonalMapper $forwardDiagonalMapper,
        HorizontalMapper $horizontalMapper,
        VerticalMapper $verticalMapper,
        IMoveObserver $moveObserver
    ) {
        $this->mappers[] = $backDiagonalMapper;
        $this->mappers[] = $forwardDiagonalMapper;
        $this->mappers[] = $horizontalMapper;
        $this->mappers[] = $verticalMapper;

        $this->moveObserver = $moveObserver;
    }

    public function playMove(Symbol $symbol, Coordinate $x, Coordinate $y)
    {
        if ($this->lastSymbol && $symbol->isEqualTo($this->lastSymbol)) {
            throw new GuardException('Not your turn');
        }

        $this->lastSymbol = $symbol;

        foreach ($this->mappers as $mapper) {
            $mapper->playMove($symbol, $x, $y);
        }

        $this->moveObserver->whenMovePlayed($symbol, $x, $y);
    }
}
