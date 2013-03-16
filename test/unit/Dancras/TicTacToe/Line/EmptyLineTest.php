<?php

namespace test\unit\Dancras\TicTacToe\Line;

use Dancras\Common\Exception\GuardException;
use Dancras\TicTacToe\Line\EmptyLine;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class EmptyLineTest extends PHPUnit_Framework_TestCase
{
    private $emptyLine;
    private $winningLineFactory;
    private $winningLine;

    public function setUp()
    {
        $this->winningLineFactory = Doubles::fromClass('\Dancras\TicTacToe\Line\WinningLineFactory');
        $this->emptyLine = new EmptyLine($this->winningLineFactory);

        $this->winningLine = Doubles::fromClass('\Dancras\TicTacToe\Line\WinningLine');
        $this->winningLineFactory->stub('create', $this->winningLine);
    }

    public function testItReturnsWinningLineWhenSymbolIsSet()
    {
        $line = $this->emptyLine->set(new Coordinate(0), new Symbol('X'));

        $this->assertSame($this->winningLine, $line);
    }

    public function testItCreatesWinningLineWithSelf()
    {
        $line = $this->emptyLine->set(new Coordinate(0), new Symbol('X'));

        $this->assertSame($this->emptyLine, $this->winningLineFactory->spy('create')->arg(0, 0));
    }

    public function testItCreatesWinningLineWithSetCoordinate()
    {
        $line = $this->emptyLine->set(new Coordinate(0), new Symbol('X'));

        $this->assertTrue($this->winningLineFactory->spy('create')->arg(0, 1)->isEqualTo(new Coordinate(0)));
    }

    public function testItCreatesWinningLineWithSetSymbol()
    {
        $line = $this->emptyLine->set(new Coordinate(0), new Symbol('X'));

        $this->assertTrue($this->winningLineFactory->spy('create')->arg(0, 2)->isEqualTo(new Symbol('X')));
    }

    public function testItRefusesCoordinatesAboveTwo()
    {
        $cross = new Symbol('X');

        $this->setExpectedException(GuardException::FQCN);
        $this->emptyLine->set(new Coordinate(3), $cross);
    }

    public function testItHasZeroCoordinates()
    {
        $this->assertSame(0, $this->emptyLine->getNumberOfCoordinates());
    }

    public function testItHasHighestCoordinateOfTwo()
    {
        $this->assertSame(2, $this->emptyLine->getHighestCoordinate());
    }

    public function testItHasSizeOfThree()
    {
        $this->assertSame(3, $this->emptyLine->getSize());
    }
}
