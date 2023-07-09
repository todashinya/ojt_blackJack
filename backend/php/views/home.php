<?php
use db\DataSource;
use model\PlayerModel;

try{
    $db =  new DataSource();
    $result = $db->select("select * from t_player where id = :id;", [':id' => 2], 'cls', 'model\PlayerModel');  
    echo('<pre>');
    var_dump($result);
    echo('</pre>');

} catch(PDOException $e) {
    echo $e->getMessage();
}

?>

<h1>ホーム画面</h1>
<a href="/game">aaaaa</a>