<?php
use db\GamaQuery;
use db\PlayerQuery;
use model\GamaModel;
use model\PlayerModel;

index();

function index() {
    try{
        $db =  new PlayerQuery();
        $result = $db->getUser();
        
        require_once SOURCE_PATH . 'views/game.php';
        
    } catch(PDOException $e) {
        echo $e->getMessage();
        require_once SOURCE_PATH . 'views/game.php';
    }
}

