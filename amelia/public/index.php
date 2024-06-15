<?php
session_start();

require_once realpath(__DIR__ . '/../config.php');
require_once realpath(__DIR__ . '/../app/controllers/RecordController.php');
require_once realpath(__DIR__ . '/../app/controllers/UserController.php');

try {
    $pdo = new PDO("mysql:host={$conf->db_server};dbname={$conf->db_name}", $conf->db_user, $conf->db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$recordController = new RecordController($pdo);
$userController = new UserController($pdo);

switch ($action) {
    case 'addRecord':
        $recordController->addRecord();
        break;
    case 'saveRecord':
        $recordController->saveRecord();
        break;
    case 'viewTable':
        $recordController->viewTable();
        break;
    case 'updateRecord':
        $recordController->updateRecord();
        break;
    case 'saveUpdate':
        $recordController->saveUpdate();
        break;
    case 'deleteRecord':
        $recordController->deleteRecord();
        break;
    case 'manageRoles':
        $userController->manageRoles();
        break;
    case 'updateRole':
        $userController->updateRole();
        break;
    default:
        $recordController->index();
        break;
}
?>
