<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\AuthController;

$authCtrl = new AuthController();
$authCtrl->logout();
