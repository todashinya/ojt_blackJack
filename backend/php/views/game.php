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
                <a href="/" class="button">退出する</a>
            </div>
            <ul class="dealer">
                <li>
                    <div class="img card-back"></div>
                    <div class="img">
                        <img src="../../img/img_10-club.png" alt="">
                    </div>
                    <div class="img">
                        <img src="../../img/img_10-club.png" alt="">
                    </div>
                    <div class="img">
                        <img src="../../img/img_10-club.png" alt="">
                    </div>
                    <?php foreach ($resultHands as $handArray) : ?>
                        <?php foreach ($handArray as $hand) : ?>
                            <img src="<?php echo $hand->image_path; ?>">
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </li>
            </ul>
            <ul class="player">
                <li>
                    <div class="img">
                        <img src="../../img/img_2-club.png" alt="">
                    </div>
                    <div class="img">
                        <img src="../../img/img_2-club.png" alt="">
                    </div>
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
                    <div class="img">
                        <img src="../../img/img_10-heart.png" alt="">
                    </div>
                    <div class="img">
                        <img src="../../img/img_10-heart.png" alt="">
                    </div>
                    <div class="img">
                        <img src="../../img/img_10-heart.png" alt="">
                    </div>
                    <div class="img">
                        <img src="../../img/img_10-heart.png" alt="">
                    </div>
                    <div class="bet">
                        <p>BET</p>
                        <p>$<?php echo $result[0]->bet; ?></p>
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