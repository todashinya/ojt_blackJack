<?php

namespace controller;

use db\CardQuery;
use db\GameQuery;
use db\PlayerQuery;
use model\CardModel;
use model\GameModel;
use model\PlayerModel;

class GameController
{
    private $mark = ['heart', 'spade', 'club', 'diamond'];

    private $number = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];

    private $playerResultHands = [];

    private $dealerHands = [];

    private $playerHands = [];


    public function __construct()
    {

    }


    public function index()
    {
        try {
            $db =  new PlayerQuery();
            $result = $db->getPlayer();

            // 初期カード配布メソッド
            // $this->dealCard();
            // $this->countHands();
            // $this->countHandsNumber();

            require_once SOURCE_PATH . 'views/game.php';
        } catch (\PDOException $e) {
            echo $e->getMessage();
            require_once SOURCE_PATH . 'views/game.php';
        }
    }

    // public function hit()
    // {
    //     $sessionData = [];
    //     $dbData = [];
    //     $hitFlag = $_POST['hit'];
        
    //     try {
    //         if ($_SERVER['REQUEST_METHOD'] === 'POST' && $hitFlag === 'hit') {

    //             $sessionData = $_SESSION['player'][0];

    //             $db = new PlayerQuery();
    //             $dbData = $db->fetchByName($sessionData->name);

    //             if ($sessionData->name === $dbData[0]->name) {
                    
    //                 $logFilePath = BASE_LOG_PATH . 'console.log';
    //                 error_log("hit event start\n", 3, $logFilePath);
    //                 error_log("hitしたプレイヤー名: " . print_r($sessionData->name, true) . "\n", 3, $logFilePath);

    //                 $hands = [];
    //                 $cards = [];

    //                 //1. ランダムでmarkとnaumberを生成
    //                 for ($i = 0; $i < count($this->mark); $i++) {
    //                     for ($j = 0; $j < count($this->number); $j++) {
    //                         $card = [
    //                             'mark' => $this->mark[$i],
    //                             'number' => $this->number[$j]
    //                         ];

    //                         $cards[] = $card;
    //                     }
    //                 }

    //                 $randKey = array_rand($cards, 1);

    //                 $dealerHands = [
    //                     $cards[$randKey]
    //                 ];
        
    //                 $playerHands = [
    //                     $cards[$randKey]
    //                 ];

    //                 $hands = $this->dealCard();

                    
    //                 //2. カードマスタから1. のimage_pathを取得
    //                 try {
    //                     $db = new CardQuery();
    //                     // ディーラーの手札
    //                     $dealerDrowHand = $db->getCard($dealerHands[0]['mark'], $dealerHands[0]['number']);
    //                     // error_log(print_r($dealerDrowHand, true), 3, $logFilePath);

    //                     // プレイヤーの手札
    //                     $playerDrowHand = $db->getCard($playerHands[0]['mark'], $playerHands[0]['number']);
    //                     error_log("引く前の手札\n" . print_r($hands, true), 3, $logFilePath);
    //                     error_log("新しく引いた手札\n" . print_r($playerDrowHand, true), 3, $logFilePath);

    //                     $this->playerResultHands = array_merge($this->playerHands, $playerDrowHand);
    //                     error_log("引いた後の手札\n" . print_r($this->playerResultHands, true), 3, $logFilePath);

    //                 } catch (\PDOException $e) {
    //                     echo $e->getMessage();
    //                 }
            
    //                 $responseData =  [
    //                     'dealerHands' => $dealerDrowHand,
    //                     'playerHands' => $playerDrowHand,
    //                 ];

    //                 header('Content-Type: application/json');
    //                 echo json_encode($responseData);
    //             }
    //         }

    //     } catch (\PDOException $e) {
    //         echo $e->getMessage();
    //     }
    // }


    /**
     * スタンドメソッド
     * 処理概要
     * 1. スタンドボタンクリック時、t_playerのstatusに1をセット
     * @return bool t_playerのstatusに1をセットできれば true / できない場合は false
     */
    public function stand()
    {
        $sessionData = [];
        $dbData = [];

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $sessionData = $_SESSION['player'][0];

                $db = new PlayerQuery();
                $dbData = $db->fetchByName($sessionData->name);

                if ($sessionData->name === $dbData[0]->name) {
                    $db->setStandStatus($sessionData->id);
                }
            }
            return true;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


    /**
     * サレンダーメソッド
     * 処理概要
     * 1. サレンダーボタンクリック時、t_playerのstatusに2をセット
     * @return bool t_playerのstatusに1をセットできれば true / できない場合は false
     */
    public function surrender()
    {
        $sessionData = [];
        $dbData = [];

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $sessionData = $_SESSION['player'][0];

                $db = new PlayerQuery();
                $dbData = $db->fetchByName($sessionData->name);

                if ($sessionData->name === $dbData[0]->name) {
                    $db->setSurrenderStatus($sessionData->id);
                }
            }
            return true;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function countHands()
    {
        // 最終決定したハンドの枚数を判定
        $handCount = count($this->playerHands);

        // $logFilePath = BASE_LOG_PATH . 'console.log';
        // error_log('手札枚数:' . $handCount, 3, $logFilePath);

        // return $handCount;
    }

    public function countHandsNumber()
    {
        // 最終決定したハンドのnumberの合計値を判定
        $handTotal = 0;

        // foreach ($this->resultHands as $cardArray) {
        //     foreach ($cardArray as $card) {
        //         //J・Q・Kの絵札はすべて10としてカウント
        //         if ($card->number >= 11 && $card->number <= 13) {
        //             $card->number = 10;
        //         }

        //         //TODO Aを1として扱うか11として扱うか

        //         $handTotal += $card->number;
        //     }
        // }

        // $logFilePath = BASE_LOG_PATH . 'console.log';
        // error_log('手札合計値:' . $handTotal, 3, $logFilePath);

    }

    public function checkWinOrLose()
    {
        // 勝敗判定を行う
        // ディーラーよりハンド合計値が低い場合は、プレイヤーの負け
        // ディーラーのハンド合計値と同じ場合は引き分け
        // ディーラーよりハンド合計値が高い場合は、プレイヤーの勝ち

    }

    public function liquidateBetAmount()
    {
        // BET額に応じて清算を行う
    }


    /**
     * 初期カード配布メソッド
     * 処理概要
     * 1. ランダムでmarkとnaumberを生成
     * 2. カードマスタから1. のimage_pathを取得
     * @return array
     */
    public function dealCard()
    {
        $hands = [];
        $cards = [];
        $sessionData = [];
        $dbData = [];

        //1. ランダムでmarkとnaumberを生成
        for ($i = 0; $i < count($this->mark); $i++) {
            for ($j = 0; $j < count($this->number); $j++) {
                $card = [
                    'mark' => $this->mark[$i],
                    'number' => $this->number[$j]
                ];

                $cards[] = $card;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $randKey = array_rand($cards, 2);

            $dealerHands = [
                $cards[$randKey[0]],
                $cards[$randKey[1]],
            ];

            $playerHands = [
                $cards[$randKey[0]],
                $cards[$randKey[1]],
            ];
        }

        //2. カードマスタから1. のimage_pathを取得
        try {
            $db = new CardQuery();
            // ディーラーの手札
            foreach ($dealerHands as $hand) {
                $this->dealerHands[] = $db->getCard($hand['mark'], $hand['number']);
            }
            // プレイヤーの手札
            foreach ($playerHands as $hand) {
                $this->playerHands[] = $db->getCard($hand['mark'], $hand['number']);
            }

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        
        $firstHands = [
            'dealerHands' => $this->dealerHands,
            'playerHands' => $this->playerHands,
        ];
        
        $logFilePath = BASE_LOG_PATH . 'console.log';
        header('Content-Type: application/json');
        $json = json_encode($firstHands);
        error_log("\n引いたカード\n" . print_r($json, true), 3, $logFilePath);
        echo $json;
    }


    /** 
     * DBプレイヤー削除
     * 処理概要
     * 1. 退出ボタンクリック時、DBプレイヤー情報物理削除
     * @return bool t_playerのプレイヤー情報全て削除できれば true / できない場合は false
     */
    public function exit()
    {
        try {
            if (isset($_SESSION['player'])) {
                $playerName = $_SESSION['player'][0]->name;
            } else {
                echo 'SESSIONがありません';
                return false;
            }

            $db = new PlayerQuery();
            $db->deletePlayer($playerName);
            return true;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
