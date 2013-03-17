<?php

namespace Dancras\TicTacToe\LineFactory;

use Dancras\TicTacToe\IWinObserver;
use Dancras\TicTacToe\Line\ILine;
use Dancras\TicTacToe\Line\WinningLine;
use Dancras\TicTacToe\LineFactory\DeadLineFactory;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

class WinningLineFactory
{
    const FQCN = '\Dancras\TicTacToe\LineFactory\WinningLineFactory';

    private $deadLineFactory;
    private $winObserver;

    public function __construct(DeadLineFactory $deadLineFactory, IWinObserver $winObserver)
    {
        $this->deadLineFactory = $deadLineFactory;
        $this->winObserver = $winObserver;
    }

    public function create(ILine $line, Coordinate $i, Symbol $symbol)
    {
        return new WinningLine(
            $this,
            $this->deadLineFactory,
            $this->winObserver,
            $line,
            $i,
            $symbol
        );
    }
}