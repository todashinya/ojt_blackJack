<section id="home">
    <div class="bg">
        <div class="unit">
            <h1>BLACKJACK</h1>
            <form id="player-form">
                <div class="name">
                    <input type="text" value="" name="name" id="textbox" placeholder="プレイヤー名を入力してください。" required>
                </div>
                <div id="play-btn" class="btn js-open">
                    <a href="" class="play">PLAY</a>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- オーバーレイ -->
<div class="overlay js-overlay"></div>
<!-- モーダルウィンドウ -->
<section class="modal-window js-modal">
    <form method="post" id="modal-form">
        <!-- 内容 -->
        <div class="content">
            <!-- 閉じるボタン -->
            <div class="button-close js-close">
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
                <input type="hidden" name="bet" id="new-bet">
                <div class="credit js-credit">＄<span>200</span></div>
                <input type="hidden" name="credit" id="new-credit">
            </div>
            <div id="start-btn" class="btn">
                <input type="hidden" name="name" id="player-name" required>
                <input type="button" value="START" class="start">
            </div>
        </div>
    </form>
</section>