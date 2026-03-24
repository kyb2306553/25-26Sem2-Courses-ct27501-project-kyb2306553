<?php

namespace App\Controllers;

use App\Models\ProductModel;

class AdminController
{
    private ProductModel $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        // Bạn nên check Session admin ở đây
    }

    // 1. Trang danh sách sản phẩm
    public function index()
    {
        $products = $this->productModel->getAllProducts();
        
        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/admin/products/index.php'; 
        require_once __DIR__ . '/../Views/footer.php';
    }

    // 2. Thêm sản phẩm
    public function create()
    {
        $categories = $this->productModel->getAllCategories();
        $brands = $this->productModel->getAllBrands();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = $this->handleUpload();
            if ($this->productModel->createProduct($_POST, $imagePath)) {
                header('Location: /index.php?url=admin/index&msg=success');
                exit;
            }
        }

        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/admin/products/create.php'; 
        require_once __DIR__ . '/../Views/footer.php';
    }

    // 3. Sửa sản phẩm
    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        $categories = $this->productModel->getAllCategories();
        $brands = $this->productModel->getAllBrands();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = $this->handleUpload() ?: null;
            if ($this->productModel->updateProduct($id, $_POST, $imagePath)) {
                header('Location: /index.php?url=admin/index&msg=updated');
                exit;
            }
        }

        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/admin/products/edit.php';
        require_once __DIR__ . '/../Views/footer.php';
    }

    // 4. Xóa sản phẩm
    public function delete($id)
    {
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /index.php?url=admin/index&msg=deleted');
            exit;
        }
    }

    // Hàm phụ xử lý upload ảnh
    private function handleUpload() {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $dir = 'public/uploads/';
            if (!is_dir($dir)) mkdir($dir, 0777, true);
            
            $filename = time() . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $dir . $filename);
            return $dir . $filename;
        }
        return null;
    }
}