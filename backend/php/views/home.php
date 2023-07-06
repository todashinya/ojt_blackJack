<?php
$a = 10;
$b = 50;
$c = 100;
$d = 500;
$bet = $a + $b + $c + $d;
$credit = 200 + $bet;
?>

<section id="home">
    <div class="bg">
        <div class="unit">
            <h1>BLACKJACK</h1>
            <form action="" method="">
                <div class="name">
                    <input type="text" value="" name="name" class="textbox" placeholder="プレイヤー名を入力してください。">
                </div>
                <div class="btn">
                    <input type="submit" value="PLAY">
                </div>
            </form>
        </div>
    </div>
    <!-- オーバーレイ -->
    <div id="overlay" class="overlay"></div>
    <!-- モーダルウィンドウ -->
    <div class="modal-window">
        <!-- 閉じるボタン -->
        <button class="js-close button-close">Close</button>
        <!-- 内容 -->
        <div class="content">
            <p>BETする金額を決めてください。</p>
            <div class="coin">
                <div class="item">
                    <label for="input-a">
                        <img src="../../img/img_coin-10.png" alt="">
                    </label>
                    <input id="input-a" type="hidden" name="10" value="<?php echo $a; ?>" onclick="calculateBet(this.value)">
                </div>
                <div class="item">
                    <label for="input-b">
                        <img src="../../img/img_coin-50.png" alt="">
                    </label>
                    <input id="input-b" type="hidden" name="50" value="<?php echo $b; ?>" onclick="calculateBet(this.value)">
                </div>
                <div class="item">
                    <label for="input-c">
                        <img src="../../img/img_coin-100.png" alt="">
                    </label>
                    <input id="input-c" type="hidden" name="100" value="<?php echo $c; ?>" onclick="calculateBet(this.value)">
                </div>
                <div class="item">
                    <label for="input-d">
                        <img src="../../img/img_coin-500.png" alt="">
                    </label>
                    <input id="input-d" type="hidden" name="500" value="<?php echo $d; ?>" onclick="calculateBet(this.value)">
                </div>
            </div>
            <div class="flex">
                <div id="bet-amount" class="bet"><?php echo '$' . $bet; ?></div>
                <div class="credit"><?php echo '$' . $credit; ?></div>
            </div>
        </div>
    </div>
</section>