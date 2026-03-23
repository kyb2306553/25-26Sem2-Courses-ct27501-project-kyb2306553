<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\AuthController;

$authController = new AuthController();
$authController->logout();
