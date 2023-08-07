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
        </div>
</section>