<?php

abstract class BaseController {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    protected function render($view, $data = []) {
        extract($data);
        $headerPath = realpath(__DIR__ . '/../views/templates/header.php');
        $viewPath = realpath(__DIR__ . '/../views/' . $view . '.php');
        $footerPath = realpath(__DIR__ . '/../views/templates/footer.php');

        if ($headerPath === false || $viewPath === false || $footerPath === false) {
            die("Error: One of the view files does not exist.");
        }

        include $headerPath;
        include $viewPath;
        include $footerPath;
    }
}
