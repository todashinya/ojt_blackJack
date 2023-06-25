<?php
require_once 'config.php';
require_once SOURCE_PATH . 'partials/header.php';


if($_SERVER['REQUEST_URI'] === '/') {
    require_once SOURCE_PATH . 'controllers/home.php';
} elseif($_SERVER['REQUEST_URI'] === '/game') {
    require_once SOURCE_PATH . 'controllers/game.php';
}

require_once SOURCE_PATH . 'partials/footer.php';

?>