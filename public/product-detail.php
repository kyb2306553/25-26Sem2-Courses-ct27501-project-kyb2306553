<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\ProductController;

$productController = new ProductController();
$productController->show();
