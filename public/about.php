<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\AboutController;

$aboutCtrl = new AboutController();
$aboutCtrl->index();
