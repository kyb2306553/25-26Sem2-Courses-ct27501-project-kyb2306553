<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\ProductCtrl;

$productCtrl = new ProductCtrl();
$productCtrl->show();
