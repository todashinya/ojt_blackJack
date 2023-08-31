<?php

namespace controller;

use db\CardQuery;
use db\GameQuery;
use db\PlayerQuery;
use model\CardModel;
use model\GameModel;
use model\PlayerModel;

require_once SOURCE_PATH . 'views/home.php';

class HomeController
{

    public function index() {
        require_once SOURCE_PATH . 'views/home.php';
    }

    public function register()
    {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $db = new PlayerQuery();
            $db->addPlayer($data);
        }

        $redirectUrl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/game";
        // $redirectUrl = "http://localhost:8080/game";
        header('Location: ' . $redirectUrl);
        exit;
    }
}
?>