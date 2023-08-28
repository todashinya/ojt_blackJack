<?php

namespace controller;

use db\PlayerQuery;
use model\PlayerModel;
use model\GameModel;

require_once SOURCE_PATH . 'views/home.php';

class HomeController
{

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [];
            $data[] = array(
                "bet" => $_POST['bet'],
                "credit" => $_POST['credit'],
                "name" => $_POST['name'],
                "startDate" => date('Y-m-d H:i:s')
            );

            $db = new PlayerQuery();
            $db->addPlayer($data);
        }
    }
}
// $homeController = new HomeController();
// $homeController->register();




// $logFilePath = BASE_LOG_PATH . 'php.log';
// error_log(print_r('logだよー', true), 3, $logFilePath);
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//     $data = [];
//     $data[] = array(
//         "bet" => $_POST['bet'],
//         "credit" => $_POST['credit'],
//         "name" => $_POST['name'],
//         "startDate" => date('Y-m-d H:i:s')
//     );

//     $db = new PlayerQuery();
//     $db->addPlayer($data);
//     // return $data;
// }
