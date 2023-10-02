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

    private $dealerHands = [];
    
    private $playerHands = [];
    
    private $resultHands = [];


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
     * 1. STANDボタンクリック時、t_playerのstatusに1をセット
     * 2. ディーラーは17になるまでカードをドローする
     * 3. 勝敗判定を行う
     * 4. 勝敗判定の結果をもとに、BET分配を行う
     * @return bool t_playerのstatusに1をセットできれば true / できない場合は false
     * @author todashinya <s.toda@jin-it.co.jp>
     */
    public function stand()
    {
        $sessionData = [];
        $dbData = [];
        $hands = [];

        $logFilePath = BASE_LOG_PATH . 'console.log';
        error_log(print_r("stand start\n", true), 3, $logFilePath);
        
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $sessionData = $_SESSION['player'][0];
                $hands = $_POST;

                $db = new PlayerQuery();
                $dbData = $db->fetchByName($sessionData->name);

                if ($sessionData->name === $dbData[0]->name) {
                    $db->setStandStatus($sessionData->id);
                }

                
                // ディーラーは17になるまでドローする
                while (true) {
                
                    $dealerDrawCard = []; // 初期化

                    $tmp = $this->dealerDrawCards();
                    $dealerDrawCard = (array)$tmp[0]; // オブジェクト形式のカードを配列に変換する                
                    array_push($hands['dealerHands'], $dealerDrawCard);

                    // カードの合計値を計算
                    $total = 0;
                    foreach ($hands['dealerHands'] as $card) {
                        if ($card['number'] >= 11 && $card['number'] <= 13) {
                            $card['number'] = 10;
                        }
                        $total += $card['number'];
                    }

                    // 合計値が17未満の場合、カードを引き続ける
                    if ($total < 17) {
                        continue;
                    } else {
                        break;
                    }
                }

                error_log(print_r("17以上にになったので勝負開始\n", true), 3, $logFilePath);
                error_log(print_r($hands['dealerHands'], true), 3, $logFilePath);

                // 勝敗判定を行う
                $resultCode = $this->checkWinOrLose($hands);

                // 勝敗判定の結果をもとに、BET分配を行う
                if (isset($resultCode)) {
                    $this->liquidateBetAmount($resultCode);
                }
            }

            return true;

        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


    /**
     * サレンダーするメソッド
     * 処理概要
     * 1. サレンダーボタンクリック時、t_playerのstatusに2をセット
     * @return bool t_playerのstatusに1をセットできれば true / できない場合は false
     * @author todashinya <s.toda@jin-it.co.jp>
     */
    public function surrender()
    {

        $logFilePath = BASE_LOG_PATH . 'console.log';
        error_log(print_r("surrender start\n", true), 3, $logFilePath);

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

                // updataBetAndCredit()に渡すsurrender時のresultCode
                $resultCode = 4;

                if (isset($resultCode)) {
                    $this->liquidateBetAmount($resultCode);
                }

                header('Content-Type: application/json');
                $json = json_encode(['resultCode' => $resultCode]);
                echo $json;
            }
            return true;

        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }




    /**
     * 最終決定したハンドの枚数と合計値を判定するメソッド
     * 
     * @param array $hands
     * @return array $resultHands['playerHandsCount'] : プレイヤーの手札枚数 / ['playerHandsTotal'] : プレイヤーの手札合計値
     * @return array $resultHands['dealerHandsCount'] : ディーラーの手札枚数 / ['dealerHandsTotal'] : ディーラーの手札合計値
     * @author todashinya <s.toda@jin-it.co.jp>
     */
    private function countHands($hands)
    {
        if (isset($hands['playerHands'])) {

            $playerHandsCount = count($hands['playerHands']);
            $playerHandsTotal = 0;
            $playerHands = $hands['playerHands'];
            $sessionData = [];

            $logFilePath = BASE_LOG_PATH . 'console.log';

            $sessionData = $_SESSION['player'][0];
            $db = new PlayerQuery();


            foreach ($playerHands as $hand) {
                //J・Q・Kの絵札はすべて10としてカウント
                if ($hand['number'] >= 11 && $hand['number'] <= 13) {
                    $hand['number'] = 10;
                }
                $playerHandsTotal += $hand['number'];

                error_log(print_r($playerHandsTotal . "\n", true), 3, $logFilePath);

                if ($playerHandsTotal === 21) {
                    $db->setBlackjackStatus($sessionData->id);
                    error_log(print_r("ブラックジャックです\n", true), 3, $logFilePath);
                } else if ($playerHandsTotal > 21) {
                    $db->setBurstStatus($sessionData->id);
                    error_log(print_r("バーストです\n", true), 3, $logFilePath);
                }
            }
        }

        if (isset($hands['dealerHands'])) {

            $dealerHandsCount = count($hands['dealerHands']);
            $dealerHandsTotal = 0;
            $dealerHands = $hands['dealerHands'];

            foreach ($dealerHands as $hand) {
                //J・Q・Kの絵札はすべて10としてカウント
                if ($hand['number'] >= 11 && $hand['number'] <= 13) {
                    $hand['number'] = 10;
                }
                $dealerHandsTotal += $hand['number'];
            }
        }

        return $resultHands = [
            'playerHandsCount' => $playerHandsCount,
            'playerHandsTotal' => $playerHandsTotal,
            'dealerHandsCount' => $dealerHandsCount,
            'dealerHandsTotal' => $dealerHandsTotal,
        ];
    }



    /**
     * 勝敗判定を行うメソッド
     * 勝敗条件
     * ディーラーよりハンド合計値が低い場合は、プレイヤーの負け
     * ディーラーのハンド合計値と同じ場合は引き分け
     * ディーラーよりハンド合計値が高い場合は、プレイヤーの勝ち
     * 
     * 関連メソッド
     * db/game.query.php > updataBetAndCredit()
     * 
     * @param array $hands:[playerとdealerの手札の枚数と合計値の配列]
     * @return $resultCode:[1]プレイヤー勝利 [2]引き分け [3]ディーラー勝利 [4]サレンダーによるディーラーの勝利 [99]例外終了
     * @author todashinya <s.toda@jin-it.co.jp>
     */

    public function checkWinOrLose($hands)
    {
        $resultHands = $this->countHands($hands);
        $resultCode = 0;

        $sessionData = [];
        $sessionData = $_SESSION['player'][0];

        //初期化
        $responseResult = [
            'resultCode' => '',
            'message' => '',
            'resultHands' => ''
        ];

        $db = new PlayerQuery();
        $player = $db->getPlayerStatus($sessionData->id);
        $status = $player[0]['status'];

        $logFilePath = BASE_LOG_PATH . 'console.log';
        error_log(print_r($resultHands, true), 3, $logFilePath);
        error_log(print_r($player[0]['status'], true), 3, $logFilePath);

        try {

            if ($status === 10) {
                error_log("プレイヤーバーストのためディーラーの勝ちです\n", 3, $logFilePath);
                $resultCode = 3;
                $message = "プレイヤーバーストのためディーラーの勝ちです";

                $responseResult = [
                    'resultCode' => $resultCode,
                    'message' => $message,
                    'resultHands' => $hands
                ];

                header('Content-Type: application/json');
                $json = json_encode($responseResult);
                echo $json;

                # TODO リファクタリングの対象
                return $resultCode;
            }

            if ($resultHands['playerHandsTotal'] > $resultHands['dealerHandsTotal'] || $resultHands['dealerHandsTotal'] > 21) {
                error_log("プレイヤーの勝ちです\n", 3, $logFilePath);
                $resultCode = 1;
                $message = "プレイヤーの勝ちです";
            } else if ($resultHands['playerHandsTotal'] === $resultHands['dealerHandsTotal']) {
                if ($resultHands['playerHandsCount'] > $resultHands['dealerHandsCount']) {
                    error_log("プレイヤーの勝ちです\n", 3, $logFilePath);
                    $resultCode = 1;
                    $message = "プレイヤーの勝ちです";
                } else if (($resultHands['playerHandsCount'] === $resultHands['dealerHandsCount'])) {
                    error_log("引き分けです\n", 3, $logFilePath);
                    $resultCode = 2;
                    $message = "引き分けです";
                } else {
                    error_log("ディーラーの勝ちです\n", 3, $logFilePath);
                    $resultCode = 3;
                    $message = "ディーラーの勝ちです";
                }
            } else {
                error_log("ディーラーの勝ちです\n", 3, $logFilePath);
                $resultCode = 3;
                $message = "ディーラーの勝ちです";
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            $resultCode = 99;
        }

        $responseResult = [
            'resultCode' => $resultCode,
            'message' => $message,
            'resultHands' => $hands
        ];

        header('Content-Type: application/json');
        $json = json_encode($responseResult);
        echo $json;

        # TODO リファクタリングの対象
        return $resultCode;
    }


    /**
     * プレイヤーの勝敗($resultCode)により、BETの分配を行うメソッド
     * 分配条件
     * $resultCode:[1]  プレイヤーのBET * 3 をCREDITに追加し BETを0でUPDATE
     * $resultCode:[2]  プレイヤーのBET を CREDIT に追加し BETを0でUPDATE
     * $resultCode:[3]  プレイヤーのBETを0でUPDATE
     * $resultCode:[4]  プレイヤーのBET / 2 をCREDITに追加し BETを0でUPDATE
     * $resultCode:[99] 例外終了のためrollback
     * @param int $resultCode:[1]プレイヤー勝利 [2]引き分け [3]ディーラー勝利 [4]サレンダーによるディーラーの勝利 [99]例外終了
     * @return void
     * @author todashinya <s.toda@jin-it.co.jp>
     */
    private function liquidateBetAmount($resultCode)
    {
        try {
            $id = isset($_SESSION['player'][0]->id) ? $_SESSION['player'][0]->id : '';

            $db = new GameQuery();
            $result = $db->updataBetAndCredit($id, $resultCode);

            $logFilePath = BASE_LOG_PATH . 'console.log';
            error_log(print_r("liquidateBetAmount start\n", true), 3, $logFilePath);
            error_log(print_r($id, true), 3, $logFilePath);
            error_log(print_r($resultCode, true), 3, $logFilePath);

            return true;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


    /**
     * 初期カード配布メソッド
     * 処理概要
     * 1. ランダムでmarkとnaumberを生成
     * 2. カードマスタから1. のimage_pathを取得
     * @return array $afterDealHands[dealerHands] : ディーラーの手札情報 / [playerHands] : プレイヤーの手札情報
     * @author todashinya <s.toda@jin-it.co.jp>
     */
    public function dealCard()
    {
        // 初期化
        $hands = [];
        $cards = [];
        $sessionData = [];
        $dbData = [];

        // マスタデータからカード情報を取得
        $db = new CardQuery();
        $cards = $db->getCardsList();

        // マスタデータからカード情報を取得
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $randKey = array_rand($cards, 4);
            $this->dealerHands = [
                $cards[$randKey[0]],
                $cards[$randKey[1]],
            ];
            $this->playerHands = [
                $cards[$randKey[2]],
                $cards[$randKey[3]],
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['hit'] === 'hit') {
            $randKey = array_rand($cards, 1);
            $this->playerHands = [$cards[$randKey]];
        }


        // 取得済みのカードは表示しないようにする
        $sessionData = $_SESSION['player'][0];
        foreach ($this->dealerHands as $hand) {
            $db->setUsedCards(99, $hand['id']);
        }
        foreach ($this->playerHands as $hand) {
            $db->setUsedCards($sessionData->id, $hand['id']);
        }

        $afterDealHands = [
            'dealerHands' => $this->dealerHands,
            'playerHands' => $this->playerHands,
        ];

        header('Content-Type: application/json');
        $json = json_encode($afterDealHands);
        echo $json;
    }



    private function dealerDrawCards()
    {
        // 初期化
        $hands = [];
        $cards = [];

        // マスタデータからカード情報を取得
        $db = new CardQuery();
        $cards = $db->getCardsList();

        $randKey = array_rand($cards, 1);
        $this->dealerHands = [$cards[$randKey]];

        $logFilePath = BASE_LOG_PATH . 'console.log';
        $sessionData = $_SESSION['player'][0];


        // 取得済みのカードは表示しないようにする
        foreach ($this->dealerHands as $hand) {
            $db->setUsedCards(99, $hand['id']);
        }

        $afterDealHands = [
            'dealerHands' => $this->dealerHands,
            'playerHands' => $this->playerHands,
        ];

        return $this->dealerHands;
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
