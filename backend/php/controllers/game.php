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

            // 初期カード配布メソッド
            $resultHands = $this->dealCard();
            
            require_once SOURCE_PATH . 'views/game.php';
            
        } catch(\PDOException $e) {
            echo $e->getMessage();
            require_once SOURCE_PATH . 'views/game.php';
        }
    }

    public function hit() {
        // hitの処理
    }

    public function stand() {
        // standの処理
    }

    public function surrender() {
        // surrenderの処理
    }

    public function countHands() {
        //  最終決定したハンドの枚数を判定
    }

    public function countHandsNumber() {
        // 最終決定したハンドのnumberの合計値を判定
    }

    public function checkWinOrLose() {
        // 勝敗判定を行う
        // ディーラーよりハンド合計値が低い場合は、プレイヤーの負け
        // ディーラーのハンド合計値と同じ場合は引き分け
        // ディーラーよりハンド合計値が高い場合は、プレイヤーの勝ち
    }

    public function liquidateBetAmount() {
        // BET額に応じて清算を行う
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