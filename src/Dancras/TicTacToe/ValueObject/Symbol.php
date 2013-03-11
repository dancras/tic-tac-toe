<?php

namespace Dancras\TicTacToe\ValueObject;

use Dancras\Common\Exception\GuardException;

class Symbol
{
    const FQCN = '\Dancras\TicTacToe\ValueObject\Symbol';

    private $value;

    public function __construct($value)
    {
        if ($value !== 'X' && $value !== 'O') {
            throw new GuardException('Symbol must be X or O');
        }

        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
