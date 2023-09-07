<?php

namespace db;

use PDO;
use db\DataSource;
use model\PlayerModel;

class PlayerQuery
{
    /**
     * nameをもとにプレイヤー情報を取得するメソッド
     */
    public function fetchByName($name)
    {
        $db = new DataSource;
        $db->openConnection();

        $sql = 'SELECT * FROM t_player WHERE name = :name;';

        $result = $db->select($sql, [':name' => $name], 'cls', 'model\PlayerModel');

        $db->closeConnection();

        return $result;
    }

    /**
     * Undocumented function
     * ゲームする最大人数のプレイヤーを取得するメソッド
     * @return void
     */
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

        $sql = 'update t_player set status = 2 where id = :id;';

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

    }

    // 退出ボタンが押下されたらプレイヤー物理削除
    public function deletePlayer()
    {
        $db = new DataSource;
        $db->openConnection();

        $sql = 'DELETE FROM t_player';

        $db->delete($sql);

        // データベース接続を閉じる
        $db->closeConnection();
    }
}
