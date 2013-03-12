<?php

namespace test\unit\Dancras\TicTacToe\LineMapper;

use Dancras\Common\Exception\ConfigurationException;
use Dancras\TicTacToe\Line;
use Dancras\TicTacToe\LineMapper\VerticalMapper;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class VerticalMapperTest extends PHPUnit_Framework_TestCase
{
    private $mapper;

    private $columns;

    public function setUp()
    {
        $this->columns = array(
            Doubles::fromClass(Line::FQCN)->stub('getSize', 3),
            Doubles::fromClass(Line::FQCN)->stub('getSize', 3),
            Doubles::fromClass(Line::FQCN)->stub('getSize', 3)
        );

        $this->mapper = new VerticalMapper($this->columns);
    }

    public function testItRefusesLessRowsThanLineSize()
    {
        $columns = array_slice($this->columns, 0, 2);

        $this->setExpectedException(ConfigurationException::FQCN);
        new VerticalMapper($columns);
    }

    public function testItOnlySetsSymbolOnColumnsMatchingXCoordinate()
    {
        $this->mapper->playMove(
            new Symbol('X'),
            new Coordinate(0),
            new Coordinate(0)
        );

        $this->mapper->playMove(
            new Symbol('X'),
            new Coordinate(1),
            new Coordinate(0)
        );

        $this->assertSame(1, $this->columns[0]->spy('set')->callCount());
        $this->assertSame(1, $this->columns[1]->spy('set')->callCount());
        $this->assertSame(0, $this->columns[2]->spy('set')->callCount());
    }

    public function testItSetsSymbolOnLineAtTheYCoordinate()
    {
        $this->mapper->playMove(
            new Symbol('X'),
            new Coordinate(0),
            new Coordinate(0)
        );

        $this->mapper->playMove(
            new Symbol('X'),
            new Coordinate(0),
            new Coordinate(1)
        );

        $this->assertTrue($this->columns[0]->spy('set')->arg(0, 0)->isEqualTo(new Coordinate(0)));
        $this->assertTrue($this->columns[0]->spy('set')->arg(1, 0)->isEqualTo(new Coordinate(1)));
    }

    public function testItSetsTheCorrectSymbol()
    {
        $this->mapper->playMove(
            new Symbol('X'),
            new Coordinate(0),
            new Coordinate(0)
        );

        $this->mapper->playMove(
            new Symbol('O'),
            new Coordinate(1),
            new Coordinate(0)
        );

        $this->assertTrue($this->columns[0]->spy('set')->arg(0, 1)->isEqualTo(new Symbol('X')));
        $this->assertTrue($this->columns[1]->spy('set')->arg(0, 1)->isEqualTo(new Symbol('O')));
    }
}
