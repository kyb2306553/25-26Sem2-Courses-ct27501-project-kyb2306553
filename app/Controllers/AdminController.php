<?php

namespace App\Controllers;

use App\Models\ProductModel;

class AdminController
{
    private ProductModel $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->requireAdmin();
    }

    public function index()
    {
        $products = $this->productModel->getAllProducts();
        $messageKey = (string) ($_GET['msg'] ?? '');

        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/admin/products/index.php';
        require_once __DIR__ . '/../Views/footer.php';
    }

    public function create()
    {
        $categories = $this->productModel->getAllCategories();
        $brands = $this->productModel->getAllBrands();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = $this->handleUpload();

            if ($this->productModel->createProduct($_POST, $imagePath)) {
                $this->redirect('/index.php?url=admin/index&msg=success');
            }

            $this->redirect('/index.php?url=admin/create&msg=error');
        }

        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/admin/products/create.php';
        require_once __DIR__ . '/../Views/footer.php';
    }

    public function edit($id)
    {
        $productId = (int) $id;
        if ($productId <= 0) {
            $this->redirect('/index.php?url=admin/index&msg=notfound');
        }

        $product = $this->productModel->getProductById($productId);
        if ($product === null) {
            $this->redirect('/index.php?url=admin/index&msg=notfound');
        }

        $categories = $this->productModel->getAllCategories();
        $brands = $this->productModel->getAllBrands();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $imagePath = $this->handleUpload();

            if ($this->productModel->updateProduct($productId, $_POST, $imagePath)) {
                $this->redirect('/index.php?url=admin/index&msg=updated');
            }

            $this->redirect('/index.php?url=admin/edit/' . $productId . '&msg=error');
        }

        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/admin/products/edit.php';
        require_once __DIR__ . '/../Views/footer.php';
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/index.php?url=admin/index');
        }

        $productId = (int) $id;
        if ($productId <= 0) {
            $this->redirect('/index.php?url=admin/index&msg=notfound');
        }

        if ($this->productModel->deleteProduct($productId)) {
            $this->redirect('/index.php?url=admin/index&msg=deleted');
        }

        $this->redirect('/index.php?url=admin/index&msg=error');
    }

    private function requireAdmin(): void
    {
        $user = $_SESSION['user'] ?? null;

        if ($user === null) {
            $_SESSION['auth_error'] = 'Bạn cần đăng nhập bằng tài khoản admin.';
            $this->redirect('/login.php');
        }

        if (($user['role'] ?? '') !== 'admin') {
            $_SESSION['auth_error'] = 'Bạn không có quyền truy cập trang quản trị.';
            $this->redirect('/index.php');
        }
    }

    private function handleUpload(): ?string
    {
        if (!isset($_FILES['image']) || !is_array($_FILES['image'])) {
            return null;
        }

        if ((int) ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ((int) $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $tmpPath = (string) $_FILES['image']['tmp_name'];
        if ($tmpPath === '' || !is_uploaded_file($tmpPath)) {
            return null;
        }

        $originalName = (string) ($_FILES['image']['name'] ?? '');
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($extension, $allowedExtensions, true)) {
            return null;
        }

        $uploadDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        $safeBaseName = preg_replace('/[^a-zA-Z0-9_-]/', '-', $baseName) ?: 'image';
        $fileName = uniqid($safeBaseName . '-', true) . '.' . $extension;
        $destination = $uploadDir . $fileName;

        if (!move_uploaded_file($tmpPath, $destination)) {
            return null;
        }

        return 'uploads/' . $fileName;
    }

    private function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }
}
