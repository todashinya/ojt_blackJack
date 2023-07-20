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

<div class="container">
    <main class="main">
        <div class="main__inner">
            <h1>BLACKJACK</h1>
            <form action="" method="POST">
                <input type="text" name="name" value="" placeholder="プレイヤー名を入力してください">
                <button type="submit" id="playBtn">PLAY</button>
            </form>
        </div>
    </main>
</div>


<!-- モーダルのHTML -->
<div id="modal" class="modal">
    <div class="modal__content">
        <span class="modal__close">&times;</span>
        <h2>BETする金額を決めてください。</h2>
        <form action="" method="post">
            <input type="text" name="bet" value="">
            <input type="text" name="credit" value="">
            <input type="hidden" name="name" value="">
            <button type="submit" id="startBtn">START</button>
        </form>
    </div>
</div>