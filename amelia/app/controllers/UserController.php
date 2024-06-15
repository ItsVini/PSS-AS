<?php

require_once realpath(__DIR__ . '/BaseController.php');
require_once realpath(__DIR__ . '/../models/UserModel.php');

class UserController extends BaseController {
    public function register() {
        $userModel = new UserModel($this->pdo);
        $success = "";
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            if ($userModel->register($username, $password, $email)) {
                $success = "User registered successfully.";
            } else {
                $error = "Username or email already exists.";
            }
        }

        $this->render('register', compact('success', 'error'));
    }

    public function login() {
        $userModel = new UserModel($this->pdo);
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $userModel->login($username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role_id'] = $user['role_id'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        }

        $this->render('login', compact('error'));
    }

    public function manageRoles() {
        $stmt = $this->pdo->query("SELECT u.user_id, u.username, r.role_name as role FROM Users u LEFT JOIN Roles r ON u.role_id = r.role_id");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->query("SELECT * FROM Roles");
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('manage_roles', compact('users', 'roles'));
    }

    public function updateRole() {
        $userId = $_POST['user_id'];
        $roleId = $_POST['role_id'];

        $stmt = $this->pdo->prepare("UPDATE Users SET role_id = ? WHERE user_id = ?");
        $stmt->execute([$roleId, $userId]);

        $this->manageRoles();
    }
}
?>
