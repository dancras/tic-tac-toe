<?php

namespace test\unit\Dancras\TicTacToe\LineMapper;

use Dancras\TicTacToe\Line;
use Dancras\TicTacToe\LineMapper\ForwardDiagonalMapper;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class ForwardDiagonalMapperTest extends PHPUnit_Framework_TestCase
{
    private $line;
    private $mapper;

    public function setUp()
    {
        $this->line = Doubles::fromClass(Line::FQCN);
        $this->line->stub('getHighestCoordinate', 2);

        $this->mapper = new ForwardDiagonalMapper($this->line);
    }

    public function testItSetsSymbolOnLineWhenMovePlayedWithCoordinatesThatAddUpToHighestCoordinate()
    {
        $this->mapper->playMove(
            new Symbol('X'),
            new Coordinate(2),
            new Coordinate(0)
        );

        $this->assertTrue($this->line->spy('set')->arg(0, 0)->isEqualTo(new Coordinate(2)));
        $this->assertTrue($this->line->spy('set')->arg(0, 1)->isEqualTo(new Symbol('X')));
    }

    public function testItOnlySetsOneCoordinateOnLine()
    {
        $this->mapper->playMove(
            new Symbol('X'),
            new Coordinate(2),
            new Coordinate(0)
        );

        $this->assertSame(1, $this->line->spy('set')->callCount());
    }

    public function testItSetsNothingOnLineWhenMovePlayedWithCoordinatesThatDoNotAddUpToHighest()
    {
        $this->mapper->playMove(
            new Symbol('X'),
            new Coordinate(0),
            new Coordinate(1)
        );

        $this->assertSame(0, $this->line->spy('set')->callCount());
    }
}
