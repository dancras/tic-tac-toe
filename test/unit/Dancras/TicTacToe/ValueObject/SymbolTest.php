<?php

namespace test\unit\Dancras\TicTacToe\ValueObject;

use Dancras\Common\Exception\GuardException;
use Dancras\TicTacToe\ValueObject\Symbol;

use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class SymbolTest extends PHPUnit_Framework_TestCase
{
    public function testItReturnsItsValueWhenX()
    {
        $symbol = new Symbol('X');

        $this->assertSame('X', $symbol->getValue('X'));
    }

    public function testItReturnsItsValueWhenO()
    {
        $symbol = new Symbol('O');

        $this->assertSame('O', $symbol->getValue('O'));
    }

    public function testItRefusesAnotherValue()
    {
        $this->setExpectedException(GuardException::FQCN);

        $symbol = new Symbol('G');
    }
}
