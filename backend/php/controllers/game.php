<?php

namespace controller;

use db\CardQuery;
use db\GameQuery;
use db\PlayerQuery;
use model\CardModel;
use model\GameModel;
use model\PlayerModel;

class GameController {

    private $mark = ['heart', 'spade', 'club', 'diamond'];

    private $number = [1,2,3,4,5,6,7,8,9,10,11,12,13];

    private $cards = [];


    public function index() {
        try{
            $db =  new PlayerQuery();
            $result = $db->getPlayer();

            $resultHands = $this->dealCard();
            
            require_once SOURCE_PATH . 'views/game.php';
            
        } catch(\PDOException $e) {
            echo $e->getMessage();
            require_once SOURCE_PATH . 'views/game.php';
        }
    }
    
    /**
     * 初期カード配布メソッド
     * 処理概要
     * 1. ランダムでmarkとnaumberを生成
     * 2. カードマスタから1. のimage_pathを取得
     * @return array $resultHands（手札の配列）
     */
    private function dealCard() {
    
        //1. ランダムでmarkとnaumberを生成
        for($i=0; $i<count($this->mark); $i++) {
            for($j=0; $j<count($this->number); $j++) {
                $card = [
                    'mark' => $this->mark[$i],
                    'number' => $this->number[$j]
                ];
    
                $this->cards[] = $card;
            }
        }

        $randKey = array_rand($this->cards, 2);

        $hands = [
            $this->cards[$randKey[0]],
            $this->cards[$randKey[1]],
        ];


        //2. カードマスタから1. のimage_pathを取得
        try{
            $db =  new CardQuery();

            foreach($hands as $hand) {
                $resultHands[] = $db->getCard($hand['mark'], $hand['number']);
            }

        } catch(\PDOException $e) {
            echo $e->getMessage();
        }

        return $resultHands;
    }
}
