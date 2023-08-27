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
                    <?php foreach ($this->resultHands as $handArray) : ?>
                        <?php foreach ($handArray as $hand) : ?>
                            <div class="img">
                                <img src="<?php echo $hand->image_path; ?>">
                            </div>
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
                <li class="player-item">
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
                    <?php foreach ($result as $column) : ?>
                        <div class="bet">
                            <p>BET</p>
                            <p>$<?php echo $column->bet; ?></p>
                        </div>
                        <div class="credit">
                            <p>CREDIT</p>
                            <p>$<?php echo $column->credit; ?></p>
                        </div>
                        <div class="name">
                            <img src="../../img/icon_player.png" alt="">
                            <p><?php echo $column->name; ?></p>
                        </div>
                    <?php endforeach; ?>
                </li>
            </ul>
        </div>
        <div class="btn">
            <button class="hit">
                <img src="../../img/img_icon-hit.png" alt="">
                <p>HIT</p>
            </button>
            <button class="stand">
                <img src="../../img/img_icon-stand.png" alt="">
                <p>STAND</p>
            </button>
            <button class="surrender">
                <img src="../../img/img_icon-surrender.png" alt="">
                <p>SURRENDER</p>
            </button>
        </div>
    </div>
    <div class="under"></div>
</section>