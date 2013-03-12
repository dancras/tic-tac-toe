<?php

namespace test\unit\Dancras\TicTacToe\LineMapper;

use Dancras\TicTacToe\Line;
use Dancras\TicTacToe\LineMapper\BackDiagonalMapper;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class BackDiagonalMapperTest extends PHPUnit_Framework_TestCase
{
    private $line;
    private $mapper;

    public function setUp()
    {
        $this->line = Doubles::fromClass(Line::FQCN);
        $this->mapper = new BackDiagonalMapper($this->line);
    }

    public function testItSetsSymbolOnLineWhenMovePlayedWithEqualCoordinates()
    {
        $this->mapper->playMove(
            new Symbol('X'),
            new Coordinate(0),
            new Coordinate(0)
        );

        $this->assertTrue($this->line->spy('set')->oneCallArg(0)->isEqualTo(new Coordinate(0)));
        $this->assertTrue($this->line->spy('set')->oneCallArg(1)->isEqualTo(new Symbol('X')));
    }

    public function testItDoesNothingToLineWhenMovePlayedWithUnequalCoordinates()
    {
        $this->mapper->playMove(
            new Symbol('X'),
            new Coordinate(0),
            new Coordinate(1)
        );

        $this->assertSame(0, $this->line->callCount());
    }
}
