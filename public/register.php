<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\AuthController;

$authCtrl = new AuthController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'register':
        $authCtrl->register();
        break;

    default:
        $authCtrl->showRegister();
        break;
}
