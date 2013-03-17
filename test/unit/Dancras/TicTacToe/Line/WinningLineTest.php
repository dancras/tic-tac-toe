<?php

namespace test\unit\Dancras\TicTacToe\Line;

use Dancras\Common\Exception\GuardException;
use Dancras\TicTacToe\Line\WinningLine;
use Dancras\TicTacToe\LineFactory\DeadLineFactory;
use Dancras\TicTacToe\LineFactory\WinningLineFactory;
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
        $this->winningLineFactory = Doubles::fromClass(WinningLineFactory::FQCN);
        $this->deadLineFactory = Doubles::fromClass(DeadLineFactory::FQCN);
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

    public function testItRepeatsSetOnExistingLine()
    {
        $coordinate = new Coordinate(0);
        $symbol = new Symbol('X');

        $this->winningLine->set($coordinate, $symbol);

        $this->existingLine->spy('set')->checkArgs($coordinate, $symbol);
    }

    public function testItReturnsNewWinningLineWhenSymbolMatchesItsOwn()
    {
        $newLine = $this->winningLine->set(new Coordinate(0), new Symbol('X'));

        $this->assertSame($this->newWinningLine, $newLine);
    }

    public function testItCreatesNewWinningLineCorrectly()
    {
        $coordinate = new Coordinate(0);
        $symbol = new Symbol('X');

        $this->winningLine->set($coordinate, $symbol);

        $this->winningLineFactory->spy('create')->checkArgs($this->winningLine, $coordinate, $symbol);
    }

    public function testItReturnsDeadLineWhenSymbolDiffersFromItsOwn()
    {
        $returnedLine = $this->winningLine->set(new Coordinate(0), new Symbol('O'));

        $this->assertSame($this->deadLine, $returnedLine);
    }

    public function testItCreatesDeadLineCorrectly()
    {
        $coordinate = new Coordinate(0);

        $this->winningLine->set($coordinate, new Symbol('O'));

        $this->deadLineFactory->spy('create')->checkArgs($this->winningLine, $coordinate);
    }

    public function testItRefusesItsOwnCoordinate()
    {
        $this->setExpectedException(GuardException::FQCN);
        $this->winningLine->set(new Coordinate(1), new Symbol('X'));
    }

    public function testItNotifiesOfWinnerWhenRestOfLineIsLongEnough()
    {
        $symbol = new Symbol('X');

        $this->existingLine->stub('getNumberOfCoordinates', 2);
        $this->existingLine->stub('getHighestCoordinate', 2);

        $winningLine = new WinningLine(
            $this->winningLineFactory,
            $this->deadLineFactory,
            $this->winObserver,
            $this->existingLine,
            new Coordinate(1),
            $symbol
        );

        $this->winObserver->spy('whenGameIsWon')->checkArgs($symbol);
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
