<?php

namespace Dancras\TicTacToe;

use Dancras\Common\Exception\GuardException;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

use Functional as F;

class Line
{
    const FQCN = '\Dancras\TicTacToe\Line';

    private $coordinates = array();

    public function set(Coordinate $i, Symbol $symbol)
    {
        if ($i->getValue() > 2) {
            throw new GuardException('Line length exceeded');
        }

        $this->coordinates[$i->getValue()] = $symbol;
    }

    public function getWinner()
    {
        if (!isset($this->coordinates[0])) {
            return null;
        }

        $head = $this->coordinates[0];

        $matching = F\tail($this->coordinates, function ($element) use ($head) {
            return $head->isEqualTo($element);
        });

        if (count($matching) === 2) {
            return $head;
        }

        return null;
    }
}