<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\ProductController;

$productCtrl = new ProductController();
$productCtrl->show();
