<?php

namespace test\unit\Dancras\TicTacToe\LineMapper;

use Dancras\TicTacToe\Line\EmptyLine;
use Dancras\TicTacToe\LineMapper\ForwardDiagonalMapper;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class ForwardDiagonalMapperTest extends PHPUnit_Framework_TestCase
{
    private $line;
    private $mapper;

    private $newLine;

    public function setUp()
    {
        $this->line = Doubles::fromClass(EmptyLine::FQCN);
        $this->line->stub('getHighestCoordinate', 2);

        $this->mapper = new ForwardDiagonalMapper($this->line);

        $this->newLine = Doubles::fromInterface('\Dancras\TicTacToe\Line\ILine');
        $this->newLine->stub('getHighestCoordinate', 2);
        $this->line->stub('set', $this->newLine);
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

    public function testItReplacesItsLineWhenSettingSymbol()
    {
        $symbol = new Symbol('X');
        $xCoordinate = new Coordinate(1);

        $this->mapper->playMove(new Symbol('X'), new Coordinate(2), new Coordinate(0));
        $this->mapper->playMove($symbol, $xCoordinate, new Coordinate(1));

        $this->assertSame(1, $this->line->spy('set')->callCount());
        $this->newLine->spy('set')->checkArgs($xCoordinate, $symbol);
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
