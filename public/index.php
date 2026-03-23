<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\HomeCtrl;

$homeCtrl = new HomeCtrl();
$homeCtrl->index();
