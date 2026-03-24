<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController
{
    public function index()
    {
        $productModel = new ProductModel();

        $products = $productModel->getAllProducts();
        $totalProducts = count($products);

        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/products/index.php';
        require_once __DIR__ . '/../Views/footer.php';
    }

    public function show()
    {
        $productModel = new ProductModel();
        $productId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $product = $productModel->getProductById($productId);

        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/products/detail.php';
        require_once __DIR__ . '/../Views/footer.php';
    }
}
