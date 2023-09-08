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

    // 確定した後の手札
    private $resultHands = [];
    private $playerHands1 = [];
    private $playerHands2 = [];
    private $playerHands3 = [];
    private $playerHands4 = [];



    public function __construct()
    {
    }


    public function index()
    {
        try {
            $db =  new PlayerQuery();
            $result = $db->getPlayer();

            // 初期カード配布メソッド
            $this->dealCard();
            // $this->dealCard();

            // $logFilePath = BASE_LOG_PATH . 'console.log';
            // error_log(print_r($this->resultHands, true), 3, $logFilePath);

            $this->countHands();
            $this->countHandsNumber();

            require_once SOURCE_PATH . 'views/game.php';
        } catch (\PDOException $e) {
            echo $e->getMessage();
            require_once SOURCE_PATH . 'views/game.php';
        }
    }

    public function hit()
    {

        //TODO:条件分岐(t_player.name = $_SESSION['name'])
        $drowCard = $this->dealCard();
        array_push($this->resultHands[], $drowCard);
    }


    /**
     * スタンドメソッド
     * 処理概要
     * 1. スタンドボタンクリック時、t_playerのstatusに1をセット
     * @return bool t_playerのstatusに1をセットできれば true / できない場合は false
     */
    public function stand()
    {
        $data = [];

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = $_POST;

                $logFilePath = BASE_LOG_PATH . 'console.log';
                error_log(print_r($data, true), 3, $logFilePath);

                $db = new PlayerQuery();
                $db->setStandStatus($data);
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
        try {

            $db = new PlayerQuery();
            $db->setSurrenderStatus();
            return true;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function countHands()
    {
        // 最終決定したハンドの枚数を判定
        $handCount = count($this->resultHands);

        $logFilePath = BASE_LOG_PATH . 'console.log';
        error_log('手札枚数:' . $handCount, 3, $logFilePath);

        // return $handCount;
    }

    public function countHandsNumber()
    {
        // 最終決定したハンドのnumberの合計値を判定
        $handTotal = 0;

        foreach ($this->resultHands as $cardArray) {
            foreach ($cardArray as $card) {
                //J・Q・Kの絵札はすべて10としてカウント
                if ($card->number >= 11 && $card->number <= 13) {
                    $card->number = 10;
                }

                //TODO Aを1として扱うか11として扱うか

                $handTotal += $card->number;
            }
        }

        $logFilePath = BASE_LOG_PATH . 'console.log';
        error_log('手札合計値:' . $handTotal, 3, $logFilePath);
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
     * @return array $resultHands（手札の配列）
     */
    private function dealCard()
    {

        $hands = [];
        $cards = [];

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

            $hands = [
                $cards[$randKey[0]],
                $cards[$randKey[1]],
            ];
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $randKey = array_rand($cards, 2);

            $playerHands1 = [
                $cards[$randKey[0]],
                $cards[$randKey[1]],
            ];
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $randKey = array_rand($cards, 2);

            $playerHands2 = [
                $cards[$randKey[0]],
                $cards[$randKey[1]],
            ];
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["hit"] == "hit") {
            $randKey = array_rand($cards, 1);

            $logFilePath = BASE_LOG_PATH . 'console.log';
            error_log('hit', 3, $logFilePath);

            $drowHands = [
                $cards[$randKey],
            ];

            $hands = array_merge($hands, $drowHands);
        }


        //2. カードマスタから1. のimage_pathを取得
        try {
            $db = new CardQuery();
            // ディーラー
            foreach ($hands as $hand) {
                $this->resultHands[] = $db->getCard($hand['mark'], $hand['number']);
            }
            // プレイヤー１
            foreach ($playerHands1 as $hand) {
                $this->playerHands1[] = $db->getCard($hand['mark'], $hand['number']);
            }
            // プレイヤー２
            foreach ($playerHands2 as $hand) {
                $this->playerHands2[] = $db->getCard($hand['mark'], $hand['number']);
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }

        return [
            'dealerHands' => $this->resultHands,
            'playerHands1' => $this->playerHands1,
            'playerHands2' => $this->playerHands2,
        ];
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
            // $logFilePath = BASE_LOG_PATH . 'console.log';
            // error_log(print_r($playerName, true), 3, $logFilePath);

            $db = new PlayerQuery();
            $db->deletePlayer($playerName);
            return true;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
