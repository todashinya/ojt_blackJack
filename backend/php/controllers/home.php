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

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                "name" => $_POST['name'],
                "bet" => $_POST['bet'],
                "credit" => $_POST['credit'],
                "startDate" => date('Y-m-d H:i:s')
            ];
        }
        $db = new PlayerQuery();
        $db->addPlayer($data);
    }

    public function run()
    {
        try {
            require_once SOURCE_PATH . 'views/game.php';
        } catch (\PDOException $e) {
            echo $e->getMessage();
            require_once SOURCE_PATH . 'views/game.php';
        }
    }
}
// $logFilePath = BASE_LOG_PATH . 'console.log';
// error_log(print_r($data, true), 3, $logFilePath);
