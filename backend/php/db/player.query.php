<?php

namespace db;

use PDO;
use db\DataSource;
use model\PlayerModel;

class PlayerQuery
{

    public function getPlayer()
    {

        $db = new DataSource;
        $db->openConnection();

        // DBから最新4つのデータを抽出
        $sql = 'SELECT id,name,bet,credit FROM t_player ORDER BY id DESC LIMIT 4;';

        $result = $db->select($sql, [], 'cls', 'model\PlayerModel');

        $db->closeConnection();

        return $result;
    }

    public function setStandStatus()
    {

        $db = new DataSource;
        $db->openConnection();

        $sql = 'update t_player set status = 1 where id = :id;';

        $result = $db->update($sql, [':id' => 2], 'cls', 'model\PlayerModel');

        $db->closeConnection();

        return $result;
    }

    public function setSurrenderStatus()
    {

        $db = new DataSource;
        $db->openConnection();

        $sql = 'update t_player set status = 1 where id = :id;';

        $result = $db->update($sql, [':id' => 2], 'cls', 'model\PlayerModel');

        $db->closeConnection();

        return $result;
    }

    // ↓POSTされた内容をDBに登録↓
    public function addPlayer($data)
    {

        $db = new DataSource;
        $db->openConnection();

        $sql = 'INSERT INTO t_player (name, bet, credit, start_date, status) VALUES (:name, :bet, :credit, :start_date, :status);';

        $params = [
            ':name' => $data['name'],
            ':bet' => $data['bet'],
            ':credit' => $data['credit'],
            ':start_date' => $data['startDate'],
            ':status' => 0,
        ];

        $db->insert($sql, $params);
        $db->closeConnection();

        // $logFilePath = BASE_LOG_PATH . 'console.log';
        // error_log(print_r($data, true), 3, $logFilePath);
    }

    // 退出ボタンが押下されたらプレイヤー物理削除
    public function deletePlayer()
    {
        $db = new DataSource;
        $db->openConnection();

        $sql = 'DELETE FROM t_player';

        $db->execute($sql);

        // データベース接続を閉じる
        $db->closeConnection();
    }
}
