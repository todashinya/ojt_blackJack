<!-- ゲーム画面 -->
<section id="game">
    <div class="bg">
        <div class="inner">
            <div class="leaving">
                <a href="/" class="button">退出する</a>
            </div>
            <ul class="dealer">
                <li class="img card-back">
                    <img src="../../img/img_ura.png" alt="トランプカード裏">
                </li>
                <li class="img">
                    <img src="../../img/img_10-club.png" alt="トランプカード裏">
                </li>
                <li class="img">
                    <img src="../../img/img_10-club.png" alt="トランプカード裏">
                </li>
                <li class="img">
                    <img src="../../img/img_10-club.png" alt="トランプカード裏">
                </li>
                <li>
                    <?php foreach ($this->resultHands as $handArray) : ?>
                        <?php foreach ($handArray as $hand) : ?>
                            <div class="img">
                                <img src="../../img/img_<?php echo $hand->image_path; ?>.png">
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </li>
            </ul>
            <ul class="player">
                <?php foreach ($result as $column) : ?>
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
                    </li>
                <?php endforeach; ?>
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