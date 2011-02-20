<?php
error_reporting(-1);

require_once('config/app.php');

try {
    $db = new PDO("mysql:host={$config['db']['hostname']};dbname={$config['db']['database']}", $config['db']['username'], $config['db']['password']);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log('Db Connection failure: ' . $e->getMessage());
}
