<?php

namespace App\Controllers;

use App\Models\ProductModel;

class HomeController
{
    public function index()
    {
        $productModel = new ProductModel();
        $featuredProducts = $productModel->getFeaturedProducts();

        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/home.php';
        require_once __DIR__ . '/../Views/footer.php';
    }
}
