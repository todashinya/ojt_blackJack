<?php
namespace db;

use PDO;
use db\DataSource;
use model\PlayerModel;

class PlayerQuery {

    public function getPlayer() {
        
        $db = new DataSource;
        $db->openConnection();

        $sql = 'select * from t_player where id = :id;';

        $result = $db->select($sql, [':id' => 2], 'cls', 'model\PlayerModel');

        $db->closeConnection();

        return $result;
    }

    public function setStandStatus() {
        
        $db = new DataSource;
        $db->openConnection();

        $sql = 'update t_player set status = 1 where id = :id;';

        $result = $db->update($sql, [':id' => 2], 'cls', 'model\PlayerModel');

        $db->closeConnection();

        return $result;
    }

    public function setSurrenderStatus() {
        
        $db = new DataSource;
        $db->openConnection();

        $sql = 'update t_player set status = 2 where id = :id;';

        $result = $db->update($sql, [':id' => 2], 'cls', 'model\PlayerModel');

        $db->closeConnection();

        return $result;
    }
    
}