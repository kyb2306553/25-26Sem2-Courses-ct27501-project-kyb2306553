<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\AboutController;

$aboutController = new AboutController();
$aboutController->index();
