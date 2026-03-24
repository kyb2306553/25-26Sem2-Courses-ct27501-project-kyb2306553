<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\HomeController;
use App\Controllers\AdminController;

$url = $_GET['url'] ?? ''; 
$url = rtrim($url, '/');
$parts = explode('/', $url);

if (!empty($parts[0]) && $parts[0] === 'admin') {
    
    $adminController = new AdminController();
    $action = $parts[1] ?? 'index';
    $id = $parts[2] ?? null; 

    switch ($action) {
        case 'index':
            $adminController->index();
            break;
        case 'create':
            $adminController->create();
            break;
        case 'edit':
            $adminController->edit($id);
            break;
        case 'delete':
            $adminController->delete($id);
            break;
        default:
            $adminController->index();
            break;
    }
    exit(); 
}

$homeController = new HomeController();
$homeController->index();
