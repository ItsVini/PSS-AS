<?php
session_start();
require_once realpath(__DIR__ . '/../config.php');
require_once realpath(__DIR__ . '/../app/models/UserModel.php');
require_once realpath(__DIR__ . '/../app/controllers/UserController.php');

try {
    $pdo = new PDO("mysql:host={$conf->db_server};dbname={$conf->db_name}", $conf->db_user, $conf->db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}

$userController = new UserController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController->login();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to the CSS file -->
</head>
<body class="login">
    <div class="login-container">
        <h2>Login</h2>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <a href="register.php">Don't have an account? Register here</a>
    </div>
</body>
</html>
