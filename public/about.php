<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\AboutCtrl;

$aboutCtrl = new AboutCtrl();
$aboutCtrl->index();
