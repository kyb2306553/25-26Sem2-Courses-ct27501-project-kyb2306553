<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\AuthController;
use App\Controllers\AuthCtrl;

$authCtrl = new AuthController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'login':
        $authCtrl->login();
        break;

    default:
        $authCtrl->showLogin();
        break;
}
