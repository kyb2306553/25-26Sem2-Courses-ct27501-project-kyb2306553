<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\CartCtrl;

$cartCtrl = new CartCtrl();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'add':
        $cartCtrl->add();
        break;

    case 'update':
        $cartCtrl->update();
        break;

    case 'remove':
        $cartCtrl->remove();
        break;

    case 'place-order':
        $cartCtrl->placeOrder();
        break;

    default:
        $cartCtrl->index();
        break;
}
