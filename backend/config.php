<?php
$url = $_SERVER['REQUEST_URI'];
define('BASE_CONTEXT_PATH', $url);
define('BASE_CSS_PATH', '/css/');
define('BASE_JS_PATH', '/js/');
define('SOURCE_PATH', __DIR__ . '/php/');