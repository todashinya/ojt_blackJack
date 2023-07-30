<section id="game">
    <div class="bg">
        <div class="inner">
            <button class="leaving">退出する</button>
            <div class="dealer"></div>
            <ul class="player">
                <li>
                    <div class="img">
                        <img src="../../img/" alt="">
                        <img src="" alt="">
                    </div>
                    <div class="bet">
                        <p>BET</p>
                        <p>$<?php echo $result[0]->bet; ?></p>
                    </div>
                    <div class="credit">
                        <p>CREDIT</p>
                        <p>$<?php echo $result[0]->credit; ?></p>
                    </div>
                    <div class="name">
                        <img src="../../img/icon_player.png" alt="">
                        <p><?php echo $result[0]->name; ?></p>
                    </div>
                </li>
                <li>
                    <div class="img">
                        <img src="../../img/" alt="">
                        <img src="" alt="">
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
                        <p>Player2</p>
                    </div>
                </li>
                <li>
                    <div class="img">
                        <img src="../../img/" alt="">
                        <img src="" alt="">
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
                        <p>Player3</p>
                    </div>
                </li>
                <li>
                    <div class="img">
                        <img src="../../img/" alt="">
                        <img src="" alt="">
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
                        <p>Player4</p>
                    </div>
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