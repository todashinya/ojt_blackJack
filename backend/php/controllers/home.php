<?php

namespace controller;

use db\CardQuery;
use db\GameQuery;
use db\PlayerQuery;
use db\DataSource;
use model\CardModel;
use model\GameModel;
use model\PlayerModel;


class HomeController
{

    public function index()
    {

        $dataArray = [];

        if (!isset($_SESSION['player'][0])) {
            $dataArray[0] = [
                'bet' => 0,
                'credit' => 200
            ];
            // var_dump($dataArray);
        } else {
            $id = $_SESSION['player'][0]->id;
            $dataArray = $this->betCreditSelect($id);
            // var_dump($_SESSION['player'][0]);
            // var_dump($dataArray);
        }
        require_once SOURCE_PATH . 'views/home.php';
    }

    /**
     * Undocumented function register()
     * home.phpモーダルのSTARTボタン初回押下時、DBとSESSIONにプレイヤー情報を新規登録するメソッド
     * home.phpモーダルのSTARTボタン2回目以降押下時、DBにプレイヤー情報（Bet/Credit）を更新するメソッド
     * @return void
     */
    public function register()
    {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $db = new PlayerQuery();
            // セッションがあったらアップデートメソッドへ
            if (isset($_SESSION['player'][0])) {
                // 既存のプレイヤー情報を取得
                $existingPlayer = $_SESSION['player'][0];
                $dbData = $db->fetchByName($existingPlayer->name);

                // セッションデータの名前を$dataに追加
                $data['session_name'] = $existingPlayer->name;

                // セッションデータの名前を含めてupdatePlayer($data)へ
                $db->updatePlayer($data);
            } else {
                $db->addPlayer($data);
            }
            $player = $db->fetchByName($data['name']);
            $_SESSION['player'] = $player;
        }
    }

    /**
     * 登録されたベットとクレジットを既存テーブル内にセレクトしてあげるメソッド
     */
    public function betCreditSelect($id)
    {

        try {
            // t_playerテーブルからidをセレクト
            $db = new DataSource;
            $db->openConnection();
            if (!isset($id)) {
                //$idが登録されてなかったらプレイヤー登録 
                $dataArray = [
                    'bet' => '0',
                    'credit' => '200'
                ];
            } else {
                $sql = 'SELECT bet, credit FROM t_player WHERE id = :id';
                $params = [
                    ':id' => $id
                ];

                $dataArray = $db->select($sql, $params);
            }
            $db->closeConnection();

            return $dataArray;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
