<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\AuthController;

$authController = new AuthController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'login':
        $authController->login();
        break;

    default:
        $authController->showLogin();
        break;
}
