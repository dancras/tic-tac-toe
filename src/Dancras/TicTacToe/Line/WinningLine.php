<?php

namespace Dancras\TicTacToe\Line;

use Dancras\Common\Exception\GuardException;
use Dancras\TicTacToe\IWinObserver;
use Dancras\TicTacToe\LineFactory\DeadLineFactory;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

class WinningLine implements ILine
{
    const FQCN = '\Dancras\TicTacToe\Line\WinningLine';

    private $winningLineFactory;
    private $deadLineFactory;

    private $line;
    private $coordinate;
    private $symbol;

    public function __construct(
        $winningLineFactory,
        DeadLineFactory $deadLineFactory,
        IWinObserver $winObserver,
        ILine $line,
        Coordinate $i,
        Symbol $symbol
    ) {
        $this->winningLineFactory = $winningLineFactory;
        $this->deadLineFactory = $deadLineFactory;
        $this->line = $line;
        $this->coordinate = $i;
        $this->symbol = $symbol;

        if ($this->line->getNumberOfCoordinates() === $this->line->getHighestCoordinate()) {
            $winObserver->whenGameIsWon($symbol);
        }
    }

    public function set(Coordinate $i, Symbol $symbol)
    {
        if ($i->isEqualTo($this->coordinate)) {
            throw new GuardException('Position is occupied');
        }

        $this->line->set($i, $symbol);

        if ($symbol->isEqualTo($this->symbol)) {
            return $this->winningLineFactory->create($this, $i, $symbol);
        }

        return $this->deadLineFactory->create($this, $i);
    }

    public function getNumberOfCoordinates()
    {
        return $this->line->getNumberOfCoordinates() + 1;
    }

    public function getHighestCoordinate()
    {
        return $this->line->getHighestCoordinate();
    }

    public function getSize()
    {
        return $this->line->getSize();
    }
}