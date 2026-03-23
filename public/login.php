<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\AuthCtrl;

$authCtrl = new AuthCtrl();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'login':
        $authCtrl->login();
        break;

    default:
        $authCtrl->showLogin();
        break;
}
