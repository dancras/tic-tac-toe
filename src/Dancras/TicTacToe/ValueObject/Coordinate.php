<?php

namespace Dancras\TicTacToe\ValueObject;

use Dancras\Common\Exception\GuardException;

class Coordinate
{
    const FQCN = '\Dancras\TicTacToe\ValueObject\Coordinate';

    private $value;

    public function __construct($value)
    {
        if (!is_numeric($value)) {
            throw new GuardException('Coordinate must be a number');
        }

        $this->value = (int) $value;

        if ($this->value < 0) {
            throw new GuardException('Coordinate must be greater than zero');
        }
    }

    public function getValue()
    {
        return $this->value;
    }

    public function isEqualTo(Coordinate $coordinate)
    {
        return $coordinate->getValue() === $this->value;
    }
}
