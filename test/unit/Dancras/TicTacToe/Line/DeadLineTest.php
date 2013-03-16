<?php

namespace test\unit\Dancras\TicTacToe\Line;

use Dancras\Common\Exception\GuardException;
use Dancras\TicTacToe\Line\DeadLine;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class DeadLineTest extends PHPUnit_Framework_TestCase
{
    private $deadLine;

    private $deadLineFactory;
    private $newDeadLine;

    private $existingLine;

    public function setUp()
    {
        $this->deadLineFactory = Doubles::fromClass('\Dancras\TicTacToe\Line\DeadLineFactory');
        $this->existingLine = Doubles::fromInterface('\Dancras\TicTacToe\Line\ILine');

        $this->deadLine = new DeadLine($this->deadLineFactory, $this->existingLine, new Coordinate(1));

        $this->newDeadLine = Doubles::fromClass(DeadLine::FQCN);
        $this->deadLineFactory->stub('create', $this->newDeadLine);
    }

    public function testItReturnsNewDeadLineWhenSet()
    {
        $returnedLine = $this->deadLine->set(new Coordinate(0), new Symbol('X'));

        $this->assertSame($this->newDeadLine, $returnedLine);
    }

    public function testItCreatesNewDeadLineCorrectly()
    {
        $coordinate = new Coordinate(0);
        $symbol = new Symbol('X');
        $this->deadLine->set($coordinate, $symbol);

        $this->deadLineFactory->spy('create')->checkArgs($this->deadLine, $coordinate, $symbol);
    }

    public function testItRepeatsSetOnExistingLine()
    {
        $coordinate = new Coordinate(0);
        $symbol = new Symbol('X');

        $this->deadLine->set($coordinate, $symbol);

        $this->existingLine->spy('set')->checkArgs($coordinate, $symbol);
    }

    public function testItRefusesItsOwnCoordinate()
    {
        $this->setExpectedException(GuardException::FQCN);
        $this->deadLine->set(new Coordinate(1), new Symbol('X'));
    }

    public function testItGetsHighestCoordinateFromExistingLine()
    {
        $this->existingLine->stub('getHighestCoordinate', 5);

        $this->assertSame(5, $this->deadLine->getHighestCoordinate());
    }

    public function testItGetsSizeFromExistingLine()
    {
        $this->existingLine->stub('getSize', 3);

        $this->assertSame(3, $this->deadLine->getSize());
    }

    public function testItAddsOneToExistingLineNumberOfCoordinates()
    {
        $this->existingLine->stub('getNumberOfCoordinates', 1);

        $this->assertSame(2, $this->deadLine->getNumberOfCoordinates());
    }
}
