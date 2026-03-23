<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\CartController;

$cartController = new CartController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'add':
        $cartController->add();
        break;

    case 'update':
        $cartController->update();
        break;

    case 'remove':
        $cartController->remove();
        break;

    case 'place-order':
        $cartController->placeOrder();
        break;

    default:
        $cartController->index();
        break;
}
