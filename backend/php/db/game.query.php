<?php
namespace db;

use PDO;
use db\DataSource;
use model\GamaModel;

class GamaQuery {

    public function getGameUser() {
        
        $db = new DataSource;
        $sql = 'select * from t_player; ';

        $result = $db->select($sql, '', 'cls', 'model\GamaModel');

        return $result;

    }

}