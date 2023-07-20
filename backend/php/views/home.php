<?php
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
?>

<section id="home">
    <div class="bg">
        <div class="unit">
            <h1>BLACKJACK</h1>
            <form action="" method="post">
                <div class="name">
                    <input type="text" value="" name="name" class="textbox" placeholder="プレイヤー名を入力してください。">
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
    <!-- 内容 -->
    <div class="content">
        <!-- 閉じるボタン -->
        <div class=" button-close js-close">
            <span></span>
        </div>
        <p>BETする金額を決めてください。</p>
        <div class="coin">
            <div class="item">
                <label for="input-a">
                    <img src="../../img/img_coin-10.png" alt="">
                    <input type="checkbox" name="coin" value="<?php echo $a; ?>" class="coin-input" id="input-a">
                </label>
            </div>
            <div class="item">
                <label for="input-b">
                    <img src="../../img/img_coin-50.png" alt="">
                    <input type="checkbox" name="coin" value="<?php echo $b; ?>" class="coin-input" id="input-b">
                </label>
            </div>
            <div class="item">
                <label for="input-c">
                    <img src="../../img/img_coin-100.png" alt="">
                    <input type="checkbox" name="coin" value="<?php echo $c; ?>" class="coin-input" id="input-c">
                </label>
            </div>
            <div class="item">
                <label for="input-d">
                    <img src="../../img/img_coin-500.png" alt="">
                    <input type="checkbox" name="coin" value="<?php echo $d; ?>" class="coin-input" id="input-d">
                </label>
            </div>
        </div>
        <div class="flex">
            <div class="bet js-bet">＄<span><?php echo $bet; ?></span></div>
            <div class="credit js-credit">＄<span><?php echo $credit; ?></span></div>
        </div>
        <div class="btn">
            <input type="submit" value="START" class="start">
        </div>
        <!-- <div class="btn">
            <input type="button" value="RESET" class="reset">
        </div> -->
    </div>
</section>