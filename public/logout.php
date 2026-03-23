<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\AuthCtrl;

$authCtrl = new AuthCtrl();
$authCtrl->logout();
