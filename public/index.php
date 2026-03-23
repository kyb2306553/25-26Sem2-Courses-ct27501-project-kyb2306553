<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\HomeController;

$homeController = new HomeController();
$homeController->index();
