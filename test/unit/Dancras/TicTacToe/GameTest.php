<?php

namespace test\unit\Dancras\TicTacToe;

use Dancras\Common\Exception\GuardException;
use Dancras\TicTacToe\Game;
use Dancras\TicTacToe\LineMapper\BackDiagonalMapper;
use Dancras\TicTacToe\LineMapper\ForwardDiagonalMapper;
use Dancras\TicTacToe\LineMapper\HorizontalMapper;
use Dancras\TicTacToe\LineMapper\VerticalMapper;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

use Doubles\Doubles;
use Doubles\Spy\CallCounter;
use PHPUnit_Framework_TestCase;

class GameTest extends PHPUnit_Framework_TestCase
{
    private $game;
    private $mappers;
    private $moveObserver;

    public function setUp()
    {
        $this->mappers = array(
            Doubles::fromClass(BackDiagonalMapper::FQCN),
            Doubles::fromClass(ForwardDiagonalMapper::FQCN),
            Doubles::fromClass(HorizontalMapper::FQCN),
            Doubles::fromClass(VerticalMapper::FQCN),
        );

        $this->moveObserver = Doubles::fromInterface('\Dancras\TicTacToe\IMoveObserver');

        $this->game = new Game(
            $this->mappers[0],
            $this->mappers[1],
            $this->mappers[2],
            $this->mappers[3],
            $this->moveObserver
        );
    }

    public function testItPlaysMoveOnItsMappers()
    {
        $coordinateX = new Coordinate(0);
        $coordinateY = new Coordinate(1);
        $symbol = new Symbol('X');

        $this->game->playMove($symbol, $coordinateX, $coordinateY);

        foreach ($this->mappers as $mapper) {
            $mapper->spy('playMove')->checkArgs($symbol, $coordinateX, $coordinateY);
        }
    }

    public function testItNotifiesOfPlayedMove()
    {
        $coordinateX = new Coordinate(0);
        $coordinateY = new Coordinate(1);
        $symbol = new Symbol('X');

        $this->game->playMove($symbol, $coordinateX, $coordinateY);

        $this->moveObserver->spy('whenMovePlayed')->checkArgs($symbol, $coordinateX, $coordinateY);
    }

    public function testItNotifiesAfterAllMappersHaveBeenPlayed()
    {
        $doubles = array_merge($this->mappers, array($this->moveObserver));
        call_user_func_array(array('\Doubles\Spy\CallCounter', 'shareNew'), $doubles);

        $this->game->playMove(new Symbol('X'), new Coordinate(0), new Coordinate(0));

        foreach ($this->mappers as $mapper) {
            $this->assertGreaterThan(
                $mapper->spy('playMove')->sharedCallOrder(0),
                $this->moveObserver->spy('whenMovePlayed')->sharedCallOrder(0)
            );
        }
    }

    public function testItRefusesTheSameSymbolTwiceInARow()
    {
        $this->game->playMove(new Symbol('X'), new Coordinate(0), new Coordinate(0));

        $this->setExpectedException(GuardException::FQCN);
        $this->game->playMove(new Symbol('X'), new Coordinate(0), new Coordinate(1));
    }
}
