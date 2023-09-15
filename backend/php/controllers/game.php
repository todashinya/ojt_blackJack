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

    # 後で削除が必要かも
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
            require_once SOURCE_PATH . 'views/game.php';

        } catch (\PDOException $e) {
            echo $e->getMessage();
            require_once SOURCE_PATH . 'views/game.php';
        }
    }


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
        $hands = [];

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $sessionData = $_SESSION['player'][0];
                $hands = $_POST;

                $db = new PlayerQuery();
                $dbData = $db->fetchByName($sessionData->name);

                if ($sessionData->name === $dbData[0]->name) {
                    $db->setStandStatus($sessionData->id);
                }

                $logFilePath = BASE_LOG_PATH . 'console.log';
                error_log("start count hands and count num\n", 3, $logFilePath);

                $this->countHands($hands);
                $this->countHandsNumber($hands);
            }
            // return true;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            // return false;
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


    // 最終決定したハンドの枚数を判定
    private function countHands($hands)
    {
        if(isset($hands['playerHands'])) {

            $playerHandsCount = count($hands['playerHands']);
            $playerHands = $hands['playerHands'];

            foreach ($playerHands as $handArray) {
                foreach ($handArray as $hand) {
                    //J・Q・Kの絵札はすべて10としてカウント
                    if ($hand['number'] >= 11 && $hand['number'] <= 13) {
                        $hand['number'] = 10;
                    }
                    $playerHandsTotal += $hand['number'];
                }
            }

            $logFilePath = BASE_LOG_PATH . 'console.log';
            error_log('プレイヤー手札枚数:' . $playerHandsCount . "\n", 3, $logFilePath);
            error_log('プレイヤー手札合計値:' . $playerHandsTotal . "\n", 3, $logFilePath);
        }

        if(isset($hands['dealerHands'])) {

            $dealerHandsCount = count($hands['dealerHands']);
            $dealerHands = $hands['dealerHands'];

            foreach ($dealerHands as $handArray) {
                foreach ($handArray as $hand) {
                    //J・Q・Kの絵札はすべて10としてカウント
                    if ($hand['number'] >= 11 && $hand['number'] <= 13) {
                        $hand['number'] = 10;
                    }
                    $dealerHandsTotal += $hand['number'];
                }
            }

            $logFilePath = BASE_LOG_PATH . 'console.log';
            error_log('ディーラー手札枚数:' . $dealerHandsCount . "\n", 3, $logFilePath);
            error_log('ディーラー手札合計値:' . $dealerHandsTotal . "\n", 3, $logFilePath);
        }

        return $handsCount = [
            'playerHandsCount' => $playerHandsCount,
            'dealerHandsCount' => $dealerHandsCount,
        ];
    }


    // 最終決定したハンドのnumberの合計値を判定
    private function countHandsNumber($hands)
    {
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
            $randKey = array_rand($cards, 4);
            $dealerHands = [
                $cards[$randKey[0]],
                $cards[$randKey[1]],
            ];
            $playerHands = [
                $cards[$randKey[2]],
                $cards[$randKey[3]],
            ];

            // calculateHandを使用してディーラーの手札の合計を計算
            $dealerTotal = $this->calculateHand($dealerHands);

            // $logFilePath = BASE_LOG_PATH . 'console.log';
            // error_log('ディーラー手札合計値:' . $dealerTotal, 3, $logFilePath);

            while ($dealerHands < 17) {
                $randKeys = array_rand($cards, 1);
                $newCard = $cards[$randKeys];
                $dealerHands[] = $newCard;

                // カードを引くたびにディーラーの手札を再計算し17になったか計算するため
                // ディーラーの手札の合計を再計算
                $dealerTotal = $this->calculateHand($dealerHands);
            }
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['hit'] === 'hit') {
            $randKey = array_rand($cards, 1);
            $dealerHands = [$cards[$randKey]];
            $playerHands = [$cards[$randKey]];
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

        $afterDealHands = [
            'dealerHands' => $this->dealerHands,
            'playerHands' => $this->playerHands,
        ];

        header('Content-Type: application/json');
        $json = json_encode($afterDealHands);
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


    public function calculateHand($dealerHands)
    {
        $value = 0;
        $ace = 0;

        foreach ($dealerHands as $card) {
            $num = $card['number'];

            // エースの処理
            if ($num === 'a') {
                // エースを11で設定
                $ace++;
                $value += 11;
            } elseif (is_numeric($num)) {
                $value += intval($num);
            } else {
                $value += 10;
            }
        }
        // 合計値を計算して返す
        return $value;
    }
}
