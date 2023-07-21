<?php
require_once SOURCE_PATH . 'views/home.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = [];
    $data[] = array(
        "bet" => $_POST['bet'],
        "credit" => $_POST['credit'],
        "name" => $_POST['name'],
        "startDate" => date('Y-m-d H:i:s')
    );
    

    echo('<pre>');
    var_dump($data ?? '');
    echo('</pre>');

}