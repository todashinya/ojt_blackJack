<?php

namespace controller;

use db\GameQuery;
use db\PlayerQuery;
use model\GameModel;
use model\PlayerModel;

class GameController {

    private $mark = ['heart', 'spade', 'club', 'diamond'];

    private $number = [1,2,3,4,5,6,7,8,9,10,11,12,13];

    private $cards = [];


    public function index() {
        try{
            $db =  new PlayerQuery();
            $result = $db->getUser();

            $this->dealCard();
            
            require_once SOURCE_PATH . 'views/game.php';
            
        } catch(\PDOException $e) {
            echo $e->getMessage();
            require_once SOURCE_PATH . 'views/game.php';
        }
    }
    
    /**
     * 初期カード配布
     * @return array 手札の配列
     */
    private function dealCard() {
    
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

        echo('<pre>');
        var_dump($hands);
        echo('</pre>');

        return $hands;

    }
}
