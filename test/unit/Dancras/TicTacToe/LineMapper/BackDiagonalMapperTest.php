<?php

namespace test\unit\Dancras\TicTacToe\LineMapper;

use Dancras\TicTacToe\Line\EmptyLine;
use Dancras\TicTacToe\LineMapper\BackDiagonalMapper;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class BackDiagonalMapperTest extends PHPUnit_Framework_TestCase
{
    private $line;
    private $mapper;

    private $newLine;

    public function setUp()
    {
        $this->line = Doubles::fromClass(EmptyLine::FQCN);
        $this->mapper = new BackDiagonalMapper($this->line);

        $this->newLine = Doubles::fromInterface('\Dancras\TicTacToe\Line\ILine');
        $this->line->stub('set', $this->newLine);
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

    public function testItReplacesItsLineWhenSettingSymbol()
    {
        $symbol = new Symbol('X');
        $xCoordinate = new Coordinate(1);

        $this->mapper->playMove(new Symbol('X'), new Coordinate(0), new Coordinate(0));
        $this->mapper->playMove($symbol, $xCoordinate, new Coordinate(1));

        $this->assertSame(1, $this->line->spy('set')->callCount());
        $this->newLine->spy('set')->checkArgs($xCoordinate, $symbol);
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
