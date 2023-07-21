<?php
require_once 'config.php';

//Model
require_once SOURCE_PATH . 'models/player.model.php';

//DB
require_once SOURCE_PATH . 'db/datasource.php';

//ヘッダ情報(css読み込みなど)
require_once SOURCE_PATH . 'partials/header.php';

//routing
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if($requestPath === '/') {
    require_once SOURCE_PATH . 'controllers/home.php';
} elseif($requestPath === '/game') {
    require_once SOURCE_PATH . 'controllers/game.php';
}


//フッタ情報(js読み込みなど)
require_once SOURCE_PATH . 'partials/footer.php';