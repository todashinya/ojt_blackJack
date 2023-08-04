<?php

namespace controller;

use db\GameQuery;
use db\PlayerQuery;
use model\GameModel;
use model\PlayerModel;

class GameController {

    function index() {
        try{
            $db =  new PlayerQuery();
            $result = $db->getUser();
            
            require_once SOURCE_PATH . 'views/game.php';
            
        } catch(\PDOException $e) {
            echo $e->getMessage();
            require_once SOURCE_PATH . 'views/game.php';
        }
    }
    
    function drowCard() {
        $mark = ['heart', 'spade', 'club', 'diamond'];
        $number = [1,2,3,4,5,6,7,8,9,10,11,12,13];
    
        for($i=0; $i<count($mark); $i++) {
            for($j=0; $j<count($number); $j++) {
                $cards = [
                    'mark' => $mark[$i],
                    'number' => $number[$j]
                ];
    
                echo('<pre>');
                var_dump($cards);
                echo('</pre>');
            }
        }
    
    }

}




// type: 'POST',
// //game.php内のfunctionを指定したい
// url: 'contorllers/game.php',