<?php
$conf = new stdClass();
$conf->db_type = 'mysql';
$conf->db_server = 'localhost';
$conf->db_name = 'mes_test';
$conf->db_user = 'sa';
$conf->db_pass = 'sa';
$conf->protocol = 'http';
$conf->server_name = 'localhost';
$conf->app_root = '/amelia';
$conf->clean_urls = false; // lub true, zależnie od konfiguracji
$conf->action_param = 'action';
$conf->root_path = dirname(__FILE__);
$conf->action_script = 'index.php';

try {
    $pdo = new PDO("mysql:host={$conf->db_server};dbname={$conf->db_name}", $conf->db_user, $conf->db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>
