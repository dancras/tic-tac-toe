<?php

namespace Dancras\TicTacToe\LineMapper;

use Dancras\Common\Exception\ConfigurationException;
use Dancras\TicTacToe\Line;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

class HorizontalMapper
{
    const FQCN = '\Dancras\TicTacToe\LineMapper\HorizontalMapper';

    private $rows;

    public function __construct(array $rows)
    {
        if (count($rows) !== $rows[0]->getSize()) {
            throw new ConfigurationException('Not enough rows configured');
        }

        $this->rows = $rows;
    }

    public function playMove(Symbol $symbol, Coordinate $x, Coordinate $y)
    {
        $this->rows[$y->getValue()]->set($x, $symbol);
    }
}
