<?php
require_once 'config.php';
require_once SOURCE_PATH . 'partials/header.php';

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if($requestPath === '/') {
    require_once SOURCE_PATH . 'controllers/home.php';
} elseif($requestPath === '/game') {
    require_once SOURCE_PATH . 'controllers/game.php';
}

require_once SOURCE_PATH . 'partials/footer.php';

?>