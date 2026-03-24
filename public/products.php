<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\ProductController;
use App\Controllers\ProductCtrl;

$productCtrl = new ProductController();
$productCtrl->index();
