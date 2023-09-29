<?php
require_once 'config.php';

//Model
require_once SOURCE_PATH . 'models/card.model.php';
require_once SOURCE_PATH . 'models/player.model.php';
require_once SOURCE_PATH . 'models/game.model.php';

//DB
require_once SOURCE_PATH . 'db/datasource.php';
require_once SOURCE_PATH . 'db/card.query.php';
require_once SOURCE_PATH . 'db/player.query.php';
require_once SOURCE_PATH . 'db/game.query.php';

session_start();

//routing
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($requestPath === '/') {
    require_once SOURCE_PATH . 'controllers/home.php';
    $home = new \controller\HomeController();
    $home->index();
} elseif ($requestPath === '/home/register') {
    require_once SOURCE_PATH . 'controllers/home.php';
    $home = new \controller\HomeController();
    $home->register();
} elseif ($requestPath === '/game') {
    require_once SOURCE_PATH . 'controllers/game.php';
    $game = new \controller\GameController();
    $game->index();
} elseif ($requestPath === '/game/dealcard') {
    require_once SOURCE_PATH . 'controllers/game.php';
    $game = new \controller\GameController();
    $game->dealCard();
} elseif ($requestPath === '/game/hit') {
    require_once SOURCE_PATH . 'controllers/game.php';
    $game = new \controller\GameController();
    $game->dealCard();
} elseif ($requestPath === '/game/stand') {
    require_once SOURCE_PATH . 'controllers/game.php';
    $game = new \controller\GameController();
    $game->stand();
} elseif ($requestPath === '/game/surrender') {
    require_once SOURCE_PATH . 'controllers/game.php';
    $game = new \controller\GameController();
    $game->surrender();
} elseif ($requestPath === '/game/exit') {
    require_once SOURCE_PATH . 'controllers/game.php';
    $game = new \controller\GameController();
    $game->exit();
    // } elseif ($requestPath === '/game/message') {
    //     require_once SOURCE_PATH . 'controllers/game.php';
    //     $game = new \controller\GameController();
    //     $game->checkWinOrLose($hand);
}
