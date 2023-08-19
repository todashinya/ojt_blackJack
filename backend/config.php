<?php
$url = $_SERVER['REQUEST_URI'];
define('BASE_CONTEXT_PATH', $url);
define('BASE_CSS_PATH', '/css/');
define('BASE_JS_PATH', '/js/');
define('BASE_LOG_PATH', __DIR__ . '/log/');
define('SOURCE_PATH', __DIR__ . '/php/');

/**
 * 簡易ログ出力
 * $logFilePath = BASE_LOG_PATH . 'console.log';
 * error_log('game読み込み', 3, $logFilePath);
 */