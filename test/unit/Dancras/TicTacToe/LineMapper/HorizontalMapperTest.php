<?php

namespace test\unit\Dancras\TicTacToe\LineMapper;

use Dancras\Common\Exception\ConfigurationException;
use Dancras\TicTacToe\Line\EmptyLine;
use Dancras\TicTacToe\LineMapper\HorizontalMapper;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class HorizontalMapperTest extends PHPUnit_Framework_TestCase
{
    private $mapper;

    private $rows;

    private $newLine;

    public function setUp()
    {
        $this->rows = array(
            Doubles::fromClass(EmptyLine::FQCN)->stub('getSize', 3),
            Doubles::fromClass(EmptyLine::FQCN)->stub('getSize', 3),
            Doubles::fromClass(EmptyLine::FQCN)->stub('getSize', 3)
        );

        $this->mapper = new HorizontalMapper($this->rows);

        $this->newLine = Doubles::fromInterface('\Dancras\TicTacToe\Line\ILine');
        $this->rows[0]->stub('set', $this->newLine);
    }

    public function testItRefusesLessRowsThanLineSize()
    {
        $rows = array_slice($this->rows, 0, 2);

        $this->setExpectedException(ConfigurationException::FQCN);
        new HorizontalMapper($rows);
    }

    public function testItOnlySetsSymbolOnRowsMatchingYCoordinate()
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

        $this->assertSame(1, $this->rows[0]->spy('set')->callCount());
        $this->assertSame(1, $this->rows[1]->spy('set')->callCount());
        $this->assertSame(0, $this->rows[2]->spy('set')->callCount());
    }

    public function testItSetsSymbolOnLineAtTheXCoordinate()
    {
        $this->mapper->playMove(
            new Symbol('X'),
            new Coordinate(0),
            new Coordinate(0)
        );

        $this->mapper->playMove(
            new Symbol('X'),
            new Coordinate(1),
            new Coordinate(1)
        );

        $this->assertTrue($this->rows[0]->spy('set')->arg(0, 0)->isEqualTo(new Coordinate(0)));
        $this->assertTrue($this->rows[1]->spy('set')->arg(0, 0)->isEqualTo(new Coordinate(1)));
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
            new Coordinate(0),
            new Coordinate(1)
        );

        $this->assertTrue($this->rows[0]->spy('set')->arg(0, 1)->isEqualTo(new Symbol('X')));
        $this->assertTrue($this->rows[1]->spy('set')->arg(0, 1)->isEqualTo(new Symbol('O')));
    }

    public function testItReplacesLineOfRowWhenSettingSymbol()
    {
        $xCoordinate = new Coordinate(1);
        $symbol = new Symbol('X');

        $this->mapper->playMove(new Symbol('X'), new Coordinate(0), new Coordinate(0));
        $this->mapper->playMove($symbol, $xCoordinate, new Coordinate(0));

        $this->newLine->spy('set')->checkArgs($xCoordinate, $symbol);
    }
}
