<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\AboutController;
use App\Controllers\AboutCtrl;

$aboutCtrl = new AboutController();
$aboutCtrl->index();
