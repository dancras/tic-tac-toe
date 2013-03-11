<?php

namespace test\unit\Dancras\TicTacToe;

use Dancras\Common\Exception\GuardException;
use Dancras\TicTacToe\Line;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;

use Doubles\Doubles;
use PHPUnit_Framework_TestCase;

class LineTest extends PHPUnit_Framework_TestCase
{
    private $line;

    public function setUp()
    {
        $this->line = new Line();
    }

    public function testItHasNoWinnerWhenEmpty()
    {
        $this->assertNull($this->line->getWinner());
    }

    public function testItReturnsWinnerWhenFilledWithMatching()
    {
        $cross = new Symbol('X');

        $this->line->set(new Coordinate(0), $cross);
        $this->line->set(new Coordinate(1), $cross);
        $this->line->set(new Coordinate(2), $cross);

        $this->assertTrue($cross->isEqualTo($this->line->getWinner()));
    }

    public function testItHasNoWinnerWhenFilledWithNonMatching()
    {
        $cross = new Symbol('X');
        $nought = new Symbol('O');

        $this->line->set(new Coordinate(0), $cross);
        $this->line->set(new Coordinate(1), $nought);
        $this->line->set(new Coordinate(2), $cross);

        $this->assertNull($this->line->getWinner());
    }

    public function testItRefusesCoordinatesAboveTwo()
    {
        $cross = new Symbol('X');

        $this->setExpectedException(GuardException::FQCN);
        $this->line->set(new Coordinate(3), $cross);
    }

}
