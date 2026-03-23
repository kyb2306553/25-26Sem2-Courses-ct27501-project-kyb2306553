<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\AuthCtrl;

$authCtrl = new AuthCtrl();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'register':
        $authCtrl->register();
        break;

    default:
        $authCtrl->showRegister();
        break;
}
