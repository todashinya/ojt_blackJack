<?php

namespace db;

use PDO;
use db\DataSource;
use model\PlayerModel;
use model\CardModel;

class CardQuery
{

    /**
     * ランダム生成されたカードのmarkとnumberをもとにcard_idを取得するメソッド
     * @param [type] $mark
     * @param [type] $number
     * @return array $result[0]：card_id
     */
    public function getCardId($mark, $number)
    {
        $db = new DataSource;
        $db->openConnection();

        $sql = "select id from mst_card where mark = :mark and number = :number;";

        $result = $db->select($sql, [':mark' => $mark, ':number' => $number], '', '');

        $db->closeConnection();

        return $result[0];
    }


    /**
     * card_idをもとにt_handテーブルにゲームで使用されているカード情報を登録するメソッド
     * @param [type] $player_id
     * @param [type] $card_id
     * @return void
     */
    public function setUsedCards($player_id, $card_id)
    {
        $db = new DataSource;
        $db->openConnection();

        $sql = "insert into t_hand (player_id, card_id) values (:player_id, :card_id);";

        $result = $db->insert($sql, [':player_id' => $player_id, ':card_id' => $card_id]);

        $db->closeConnection();
    }


    /**
     * ゲームで使用されていないカードを取得するメソッド
     * @param [type] $mark
     * @param [type] $number
     * @return array $result
     */
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
