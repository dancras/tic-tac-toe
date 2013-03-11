<?php

namespace test\unit\Dancras\TicTacToe\ValueObject;

use Dancras\Common\Exception\GuardException;
use Dancras\TicTacToe\ValueObject\Coordinate;

use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class CoordinateTest extends PHPUnit_Framework_TestCase
{
    public function testItReturnsItsValue()
    {
        $coordinate = new Coordinate(1);

        $this->assertSame(1, $coordinate->getValue());
    }

    public function testItAcceptsNumericStrings()
    {
        $coordinate = new Coordinate("2");

        $this->assertSame(2, $coordinate->getValue());
    }

    public function testItRefusesNonNumericValues()
    {
        $this->setExpectedException(GuardException::FQCN);

        $coordinate = new Coordinate(null);
    }

    public function testItRefusesNumbersBelowZero()
    {
        $this->setExpectedException(GuardException::FQCN);

        $coordinate = new Coordinate(-1);
    }

    public function testIsEqualToIsTrueGivenMatching()
    {
        $coordinate = new Coordinate(1);

        $this->assertTrue($coordinate->isEqualTo(new Coordinate(1)));
    }

    public function testIsEqualToIsFalseGivenNonMatching()
    {
        $coordinate = new Coordinate(0);

        $this->assertFalse($coordinate->isEqualTo(new Coordinate(1)));
    }
}
