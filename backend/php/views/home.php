<?php

use db\DataSource;
use model\PlayerModel;

// try{
//     $db =  new DataSource();
//     $result = $db->select("select * from t_player where id = :id;", [':id' => 2], 'cls', 'model\PlayerModel');  
//     echo('<pre>');
//     var_dump($result);
//     echo('</pre>');

// } catch(PDOException $e) {
//     echo $e->getMessage();
// }

?>

<!-- <div class="container">
    <main class="main">
        <div class="main__inner">
            <h1>BLACKJACK</h1>
            <form action="" method="POST">
                <input type="text" name="name" value="" placeholder="プレイヤー名を入力してください">
                <button type="submit" id="playBtn">PLAY</button>
            </form>
        </div>
    </main>
</div>


モーダルのHTML
<div id="modal" class="modal">
    <div class="modal__content">
        <span class="modal__close">&times;</span>
        <h2>BETする金額を決めてください。</h2>
        <form action="" method="post">
            <input type="text" name="bet" value="">
            <input type="text" name="credit" value="">
            <input type="hidden" name="name" value="">
            <button type="submit" id="startBtn">START</button>
        </form>
    </div>
</div> -->
<!-- <?php
        $a = 10; // コイン10
        $b = 50; // コイン50
        $c = 100; // コイン100
        $d = 500; // コイン500

        $bet = 0; // ベットの初期値
        $credit = 200; // クレジットの初期値

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST['coin'])) {
                $selectedCoins = $_POST['coin']; // 選択されたコインの配列
                foreach ($selectedCoins as $coin) {
                    $coinValue = (int)$coin;
                    $bet += $coinValue; // ベットに選択されたコインの金額を加算
                    $credit -= $coinValue; // クレジットから選択されたコインの金額を減算
                }
            }
        }
        ?> -->

<section id="home">
    <div class="bg">
        <div class="unit">
            <h1>BLACKJACK</h1>
            <form action="game" method="post" id="home-form">
                <div class="name">
                    <input type="text" value="" name="name" class="textbox" placeholder="プレイヤー名を入力してください。" required>
                </div>
                <div class="btn js-open">
                    <input type="submit" value="PLAY" class="play">
                </div>
            </form>
        </div>
    </div>
</section>

<!-- オーバーレイ -->
<div class="overlay js-overlay"></div>
<!-- モーダルウィンドウ -->
<section class="modal-window js-modal">
    <form action="game" method="post" id="modal-form" name="modal-form">
        <!-- 内容 -->
        <div class="content">
            <!-- 閉じるボタン -->
            <div class="button-close js-close" onclick="reset">
                <span></span>
            </div>
            <p>BETする金額を決めてください。</p>
            <div class="coins">
                <div class="item">
                    <label for="input-a" class="coin">
                        <img src="../../img/img_coin-10.png" alt="">
                        <input type="hidden" value="10" id="input-a">
                    </label>
                </div>
                <div class="item">
                    <label for="input-b" class="coin">
                        <img src="../../img/img_coin-50.png" alt="">
                        <input type="hidden" value="50" id="input-b">
                    </label>
                </div>
                <div class="item">
                    <label for="input-c" class="coin">
                        <img src="../../img/img_coin-100.png" alt="">
                        <input type="hidden" value="100" id="input-c">
                    </label>
                </div>
                <div class="item">
                    <label for="input-d" class="coin">
                        <img src="../../img/img_coin-500.png" alt="">
                        <input type="hidden" value="500" id="input-d">
                    </label>
                </div>
            </div>
            <div class="flex">
                <div class="bet js-bet">＄<span>0</span></div>
                <div class="credit js-credit">＄<span>200</span></div>
            </div>
            <div class="btn">
                <input type="submit" value="START" class="start">
            </div>
            <!-- <div class="btn">
            <input type="button" value="RESET" class="reset">
        </div> -->
        </div>
    </form>
</section>