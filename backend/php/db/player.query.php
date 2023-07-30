<?php
namespace db;

use PDO;
use db\DataSource;
use model\PlayerModel;

class PlayerQuery {

    public function getUser() {
        
        $db = new DataSource;
        $sql = 'select * from t_player where id = :id;';

        $result = $db->select($sql, [':id' => 2], 'cls', 'model\PlayerModel');

        return $result;

    }

}