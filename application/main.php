<?php
error_reporting(-1);
ini_set('display_errors', 1);

require_once('config/app.php');

require_once('head.php');
require_once('menu.php');



try {
    $db = new PDO("mysql:host={$config['db']['hostname']};dbname={$config['db']['database']}", $config['db']['username'], $config['db']['password']);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log('Db Connection failure: ' . $e->getMessage());
}

switch ($_SERVER['REQUEST_URI']) {
    case '/add':
        require_once('add.php');
    break;

    default:
        require_once('search.php');
    break;
}

require_once('foot.php');
