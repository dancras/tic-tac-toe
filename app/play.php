<?php

session_start();

require '../vendor/autoload.php';

use Dancras\TicTacToe\Game;
use Dancras\TicTacToe\Line\EmptyLine;
use Dancras\TicTacToe\LineFactory\DeadLineFactory;
use Dancras\TicTacToe\LineFactory\WinningLineFactory;
use Dancras\TicTacToe\LineMapper\BackDiagonalMapper;
use Dancras\TicTacToe\LineMapper\ForwardDiagonalMapper;
use Dancras\TicTacToe\LineMapper\HorizontalMapper;
use Dancras\TicTacToe\LineMapper\VerticalMapper;
use Dancras\TicTacToe\ValueObject\Coordinate;
use Dancras\TicTacToe\ValueObject\Symbol;
use Dancras\TicTacToeApp\CompositeObserver;
use Dancras\TicTacToeApp\Grid;
use Dancras\TicTacToeApp\Messenger;
use Dancras\TicTacToeApp\Moves;

$moves = new Moves;
$grid = new Grid(3);
$messenger = new Messenger;

$compositeObserver = new CompositeObserver;
$compositeObserver->add($grid);
$compositeObserver->add($messenger);

try {

    $deadLineFactory = new DeadLineFactory;
    $winningLineFactory = new WinningLineFactory($deadLineFactory, $compositeObserver);

    $game = new Game(
        new BackDiagonalMapper(new EmptyLine($winningLineFactory)),
        new ForwardDiagonalMapper(new EmptyLine($winningLineFactory)),
        new HorizontalMapper(array(
            new EmptyLine($winningLineFactory),
            new EmptyLine($winningLineFactory),
            new EmptyLine($winningLineFactory)
        )),
        new VerticalMapper(array(
            new EmptyLine($winningLineFactory),
            new EmptyLine($winningLineFactory),
            new EmptyLine($winningLineFactory)
        )),
        $compositeObserver
    );

    try {

        $moves->replayMoves($game);

        $compositeObserver->add($moves);

        if (isset($_POST['symbol'])) {
            $game->playMove(
                new Symbol($_POST['symbol']),
                new Coordinate($_POST['xCoordinate']),
                new Coordinate($_POST['yCoordinate'])
            );
        }

    } catch (RuntimeException $e) {
        $messenger->addMessage($e->getMessage());
    }

} catch (Exception $e) {
    $messenger->addMessage('An unexpected error occurred');
}

?>
<pre>
<?=$grid->getRendered()?>    
</pre>
<?php foreach ($messenger->getMessages() as $message): ?>
<p><?=$message?></p>
<?php endforeach; ?>
<form action="" method="POST">
    <select name="symbol"><option value="X">X</option><option value="O">O</option></select><br />
    X <select name="xCoordinate"><option value="0">0</option><option value="1">1</option><option value="2">2</option></select><br />
    Y <select name="yCoordinate"><option value="0">0</option><option value="1">1</option><option value="2">2</option></select><br />
    <button type="submit">Play move</button>
</form>
<p><a href="new.php">Start new game</a></p>
