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


//ヘッダ情報(css読み込みなど)
require_once SOURCE_PATH . 'partials/header.php';

//routing
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if($requestPath === '/') {
    require_once SOURCE_PATH . 'controllers/home.php';
} elseif($requestPath === '/game') {
    require_once SOURCE_PATH . 'controllers/game.php';
    $game = new \controller\GameController();
    $game->index();
} elseif($requestPath === '/game/hit') {
    require_once SOURCE_PATH . 'controllers/game.php';
    $game = new \controller\GameController();
    $game->index(); //hit()読み込みにできるならそうしたい
} elseif($requestPath === '/game/stand') {
    require_once SOURCE_PATH . 'controllers/game.php';
    $game = new \controller\GameController();
    $game->stand();
} elseif($requestPath === '/game/surrender') {
    require_once SOURCE_PATH . 'controllers/game.php';
    $game = new \controller\GameController();
    $game->surrender();
}


//フッタ情報(js読み込みなど)
require_once SOURCE_PATH . 'partials/footer.php';