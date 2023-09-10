<?php

namespace db;

use PDO;
use db\DataSource;
use model\CardModel;

class CardQuery
{

    public function getCard($mark, $number)
    {

        $db = new DataSource;
        $db->openConnection();

        $sql = <<<SQL
            select * from mst_card
                where mark = :mark
                and number = :number;
        SQL;

        $result = $db->select($sql, [':mark' => $mark, ':number' => $number], 'cls', 'model\CardModel');

        $db->closeConnection();

        return $result;
    }
}
