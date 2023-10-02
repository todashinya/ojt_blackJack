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

    public function index()
    {
        require_once SOURCE_PATH . 'views/home.php';
    }

    /**
     * Undocumented function register()
     * home.phpモーダルのSTARTボタン押下時、DBとSESSIONにプレイヤー情報を登録するメソッド
     * @return void
     */
    public function register()
    {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $db = new PlayerQuery();


            // 既存のプレイヤーが存在するか確認
            $existing = $db->fetchByName($data['name']);
            if ($existing) {
                // 存在する場合情報を更新
                $db->updatePlayer($data);
            } else {
                // 既存のプレイヤーが存在していたら新規登録
                $db->addPlayer($data);
            }

            // 登録か更新後、プレイヤー情報を保存
            $player = $db->fetchByName($data['name']);
            $_SESSION['player'] = $player;
            // $logFilePath = BASE_LOG_PATH . 'console.log';
            // error_log(print_r($_SESSION['player'], true), 3, $logFilePath);
        }
    }
}
