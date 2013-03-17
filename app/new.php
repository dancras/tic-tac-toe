<?php

session_start();

require '../vendor/autoload.php';

use Dancras\TicTacToeApp\Moves;

$moves = new Moves;
$moves->clearMoves();

header('Location: play.php');