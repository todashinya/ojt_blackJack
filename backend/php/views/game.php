<?php
$playerName = $_POST['newPlayerName'];
$bet = $_POST['newBet'];
$credit = $_POST['newCredit'];
?>
<!-- ゲーム画面 -->
<section id="game">
    <div class="bg">
        <div class="inner">
            <div class="leaving">
                <button class="button">退出する</button>
            </div>
            <ul class="dealer">
                <li>
                    <div class="img card-back"></div>
                </li>
            </ul>
            <ul class="player">
                <li>
                    <div class="img"></div>
                    <div class="bet">
                        <p>BET</p>
                        <p>$500</p>
                    </div>
                    <div class="credit">
                        <p>CREDIT</p>
                        <p>$500</p>
                    </div>
                    <div class="name">
                        <img src="../../img/icon_player.png" alt="">
                        <p>Player1</p>
                    </div>
                </li>
                <li>
                    <div class="img"></div>
                    <div class="bet">
                        <p>BET</p>
                        <p>$500</p>
                    </div>
                    <div class="credit">
                        <p>CREDIT</p>
                        <p>$500</p>
                    </div>
                    <div class="name">
                        <img src="../../img/icon_player.png" alt="">
                        <p>Player2</p>
                    </div>
                </li>
                <li>
                    <div class="img"></div>
                    <div class="bet">
                        <p>BET</p>
                        <p>$500</p>
                    </div>
                    <div class="credit">
                        <p>CREDIT</p>
                        <p>$500</p>
                    </div>
                    <div class="name">
                        <img src="../../img/icon_player.png" alt="">
                        <p>Player3</p>
                    </div>
                </li>
                <li>
                    <div class="img"></div>
                    <div class="bet">
                        <p>BET</p>
                        <p>$<?php echo $bet; ?></p>
                    </div>
                    <div class="credit">
                        <p>CREDIT</p>
                        <p>$<?php echo $credit; ?></p>
                    </div>
                    <div class="name">
                        <img src="../../img/icon_player.png" alt="">
                        <p><?php echo $playerName; ?></p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="btn">
            <button class="hit" type="submit">
                <img src="../../img/img_icon-hit.png" alt="">
                <p>HIT</p>
            </button>
            <button class="stand" onclick="stand()">
                <img src="../../img/img_icon-stand.png" alt="">
                <p>STAND</p>
            </button>
            <button class="surrender" onclick="surrender()">
                <img src="../../img/img_icon-surrender.png" alt="">
                <p>SURRENDER</p>
            </button>
        </div>
    </div>
    <div class="under"></div>
</section>