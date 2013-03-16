<?php

namespace test\unit\Dancras\TicTacToe\Line;

use Dancras\Common\Exception\GuardException;
use Dancras\TicTacToe\Line\WinningLine;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class WinningLineTest extends PHPUnit_Framework_TestCase
{
    private $winningLine;
    private $existingLine;
    private $winObserver;

    private $winningLineFactory;
    private $newWinningLine;

    private $deadLineFactory;
    private $deadLine;

    public function setUp()
    {
        $this->winningLineFactory = Doubles::fromClass('\Dancras\TicTacToe\Line\WinningLineFactory');
        $this->deadLineFactory = Doubles::fromClass('\Dancras\TicTacToe\Line\DeadLineFactory');
        $this->winObserver = Doubles::fromInterface('\Dancras\TicTacToe\IWinObserver');
        $this->existingLine = Doubles::fromInterface('\Dancras\TicTacToe\Line\ILine');
        $this->winningLine = new WinningLine(
            $this->winningLineFactory,
            $this->deadLineFactory,
            $this->winObserver,
            $this->existingLine,
            new Coordinate(1),
            new Symbol('X')
        );

        $this->newWinningLine = Doubles::fromClass(WinningLine::FQCN);
        $this->winningLineFactory->stub('create', $this->newWinningLine);

        $this->deadLine = Doubles::fromClass('\Dancras\TicTacToe\Line\DeadLine');
        $this->deadLineFactory->stub('create', $this->deadLine);
    }

    public function testItSetsCoordinateOnExistingLine()
    {
        $this->winningLine->set(new Coordinate(0), new Symbol('X'));

        $this->assertTrue($this->existingLine->spy('set')->arg(0, 0)->isEqualTo(new Coordinate(0)));
    }

    public function testItSetsSymbolOnExistingLine()
    {
        $this->winningLine->set(new Coordinate(0), new Symbol('X'));

        $this->assertTrue($this->existingLine->spy('set')->arg(0, 1)->isEqualTo(new Symbol('X')));
    }

    public function testItReturnsNewWinningLineWhenSymbolMatchesItsOwn()
    {
        $newLine = $this->winningLine->set(new Coordinate(0), new Symbol('X'));

        $this->assertSame($this->newWinningLine, $newLine);
    }

    public function testItCreatesNewWinningLineWithSelf()
    {
        $this->winningLine->set(new Coordinate(0), new Symbol('X'));

        $this->assertSame($this->winningLine, $this->winningLineFactory->spy('create')->arg(0, 0));
    }

    public function testItCreatesNewWinningLineWithSetCoordinate()
    {
        $this->winningLine->set(new Coordinate(0), new Symbol('X'));

        $this->assertTrue($this->winningLineFactory->spy('create')->arg(0, 1)->isEqualTo(new Coordinate(0)));
    }

    public function testItCreatesNewWinningLineWithSetSymbol()
    {
        $this->winningLine->set(new Coordinate(0), new Symbol('X'));

        $this->assertTrue($this->winningLineFactory->spy('create')->arg(0, 2)->isEqualTo(new Symbol('X')));
    }

    public function testItReturnsDeadLineWhenSymbolDiffersFromItsOwn()
    {
        $returnedLine = $this->winningLine->set(new Coordinate(0), new Symbol('O'));

        $this->assertSame($this->deadLine, $returnedLine);
    }

    public function testItCreatesDeadLineWithSelf()
    {
        $this->winningLine->set(new Coordinate(0), new Symbol('O'));

        $this->assertSame($this->winningLine, $this->deadLineFactory->spy('create')->arg(0, 0));
    }

    public function testItCreatesDeadLineWithSetCoordinate()
    {
        $this->winningLine->set(new Coordinate(0), new Symbol('O'));

        $this->assertTrue($this->deadLineFactory->spy('create')->arg(0, 1)->isEqualTo(new Coordinate(0)));
    }

    public function testItCreatesDeadLineWithSetSymbol()
    {
        $this->winningLine->set(new Coordinate(0), new Symbol('O'));

        $this->assertTrue($this->deadLineFactory->spy('create')->arg(0, 2)->isEqualTo(new Symbol('O')));
    }

    public function testItRefusesItsOwnCoordinate()
    {
        $this->setExpectedException(GuardException::FQCN);
        $this->winningLine->set(new Coordinate(1), new Symbol('X'));
    }

    public function testItNotifiesOfWinnerWhenRestOfLineIsLongEnough()
    {
        $this->existingLine->stub('getNumberOfCoordinates', 2);
        $this->existingLine->stub('getHighestCoordinate', 2);

        $winningLine = new WinningLine(
            $this->winningLineFactory,
            $this->deadLineFactory,
            $this->winObserver,
            $this->existingLine,
            new Coordinate(1),
            new Symbol('X')
        );

        $this->assertTrue($this->winObserver->spy('whenGameIsWon')->arg(0, 0)->isEqualTo(new Symbol('X')));
    }

    public function testItGetsHighestCoordinateFromExistingLine()
    {
        $this->existingLine->stub('getHighestCoordinate', 5);

        $this->assertSame(5, $this->winningLine->getHighestCoordinate());
    }

    public function testItGetsSizeFromExistingLine()
    {
        $this->existingLine->stub('getSize', 3);

        $this->assertSame(3, $this->winningLine->getSize());
    }

    public function testItAddsOneToExistingLineNumberOfCoordinates()
    {
        $this->existingLine->stub('getNumberOfCoordinates', 1);

        $this->assertSame(2, $this->winningLine->getNumberOfCoordinates());
    }
}
