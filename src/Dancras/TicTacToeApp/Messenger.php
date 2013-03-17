<?php

namespace Dancras\TicTacToeApp;

use Dancras\TicTacToe\IWinObserver;
use Dancras\TicTacToe\ValueObject\Symbol;

class Messenger implements IWinObserver
{
    const FQCN = '\Dancras\TicTacToeApp\Messenger';

    private $messages = array();

    public function addMessage($message)
    {
        $this->messages[] = $message;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function whenGameIsWon(Symbol $symbol)
    {
        $this->addMessage('Player ' . $symbol->getValue() . ' has won!');
    }
}
