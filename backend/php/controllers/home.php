<?php
require_once SOURCE_PATH . 'views/home.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    echo('<pre>');
    var_dump($_POST ?? '');
    echo('</pre>');

    

}