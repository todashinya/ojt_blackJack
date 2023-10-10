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

        $sql = 'SELECT id,name,bet,credit FROM t_player ORDER BY id DESC LIMIT 4;';

        $result = $db->select($sql, [], 'cls', 'model\PlayerModel');

        $db->closeConnection();

        return $result;
    }


    public function getPlayerStatus($id)
    {
        $db = new DataSource;
        $db->openConnection();

        $sql = 'SELECT status FROM t_player WHERE id = :id;';

        $result = $db->select($sql, [':id' => $id], '', '');

        $db->closeConnection();

        return $result;
    }



    public function setStandStatus($id)
    {
        $db = new DataSource;
        $db->openConnection();

        $sql = 'update t_player set status = 1 where id = :id;';

        $result = $db->update($sql, [':id' => $id], 'cls', 'model\PlayerModel');

        $db->closeConnection();

        return $result;
    }


    public function setSurrenderStatus($id)
    {
        $db = new DataSource;
        $db->openConnection();

        $sql = 'update t_player set status = 2 where id = :id;';

        $result = $db->update($sql, [':id' => $id], 'cls', 'model\PlayerModel');

        $db->closeConnection();

        return $result;
    }


    public function setBlackjackStatus($id)
    {
        $db = new DataSource;
        $db->openConnection();

        $sql = 'update t_player set status = 20 where id = :id;';

        $result = $db->update($sql, [':id' => $id], 'cls', 'model\PlayerModel');

        $db->closeConnection();

        return $result;
    }


    public function setBurstStatus($id)
    {
        $db = new DataSource;
        $db->openConnection();

        $sql = 'update t_player set status = 10 where id = :id;';

        $result = $db->update($sql, [':id' => $id], 'cls', 'model\PlayerModel');

        $db->closeConnection();

        return $result;
    }

    /**
     * POSTされた内容をDBに登録するメソッド
     */
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

    /**
     * ゲーム2回目のプレイヤー情報を
     * 既存セッションデータの名前から既存情報に更新するメソッド
     */
    public function updatePlayer($data)
    {
        $logFilePath = BASE_LOG_PATH . 'console.log';
        error_log(print_r($data, true), 3, $logFilePath);
        $db = new DataSource;
        $db->openConnection();
        try {
            $sql = 'UPDATE t_player SET bet = :bet, credit = :credit, status = :status WHERE name = :session_name;';

            $params = [
                ':session_name' => $data['session_name'],
                ':bet' => $data['bet'],
                ':credit' => $data['credit'],
                ':status' => 0,
            ];
            $db->update($sql, $params, 'cls', 'model\PlayerModel');
            $db->commit();
            $db->closeConnection();


            return true;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            $db->rollback();
        }
    }

    /**
     * 退出ボタンが押下されたらプレイヤー物理削除するメソッド
     */
    public function deletePlayer($playerName)
    {
        $db = new DataSource;
        $db->openConnection();

        $sql = 'DELETE FROM t_player WHERE name = :name LIMIT 1';

        $db->delete($sql, [':name' => $playerName]);

        // セッションデータも削除
        unset($_SESSION['player']);

        // データベース接続を閉じる
        $db->closeConnection();
    }
}
