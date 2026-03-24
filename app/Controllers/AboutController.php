<?php

namespace App\Controllers;

class AboutController
{
    public function index()
    {
        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/about/index.php';
        require_once __DIR__ . '/../Views/footer.php';
    }
}
