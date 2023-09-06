<!-- ゲーム画面 -->
<section id="game">
    <div class="bg">
        <div class="inner">
            <div class="leaving">
                <a href="/" class="button">退出する</a>
            </div>
            <ul class="dealer">
                <li>
                    <div class="img card-back">
                        <img src="/img/img_ura.png" alt="トランプカード裏">
                    </div>
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
                <?php foreach ($result as $column) : ?>
                    <li>
                        <?php foreach ($this->playerHands1 as $handArray) : ?>
                            <?php foreach ($handArray as $hand) : ?>
                                <div class="img">
                                    <img src="<?php echo $hand->image_path; ?>">
                                </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
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