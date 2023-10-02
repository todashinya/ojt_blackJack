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
    public function getCardsList()
    {
        $db = new DataSource;
        $db->openConnection();

        $sql = <<<SQL
            select 
                p.id,
                c.id, 
                c.mark,
                c.number,
                c.image_path
            from mst_card c  
            left join t_hand h 
            on c.id = h.card_id 
            left join t_player p
            on p.id = h.player_id
            where h.card_id IS NULL
        SQL;

        $result = $db->select($sql, [], '', '');

        $db->closeConnection();

        return $result;
    }
}