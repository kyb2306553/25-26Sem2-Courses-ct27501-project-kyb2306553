<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductModel;

class CartController
{
    private CartModel $cartModel;
    private ProductModel $productModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $this->requireLogin();

        $cart = $this->cartModel->getCart();
        $cartItems = $this->buildCartItems($cart);
        $cartCount = $this->cartModel->getTotalQuantity();
        $cartTotal = array_sum(array_column($cartItems, 'subtotal'));
        $successMessage = $_SESSION['success_message'] ?? null;
        $errorMessage = $_SESSION['error_message'] ?? null;
        unset($_SESSION['success_message'], $_SESSION['error_message']);

        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/cart/index.php';
        require_once __DIR__ . '/../Views/footer.php';
    }

    public function add()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/products.php');
        }

        $productId = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;
        $quantity = max($quantity, 1);

        $product = $this->productModel->getProductById($productId);

        if ($product === null) {
            $_SESSION['error_message'] = 'Sản phẩm không tồn tại.';
            $this->redirect('/products.php');
        }

        if ((int) $product['stock'] <= 0) {
            $_SESSION['error_message'] = 'Sản phẩm này hiện đang hết hàng.';
            $this->redirect('/product-detail.php?id=' . $productId);
        }

        $this->cartModel->add($productId, $quantity, (int) $product['stock']);
        $_SESSION['success_message'] = 'Đã thêm sản phẩm vào giỏ hàng.';

        $this->redirect('/cart.php');
    }

    public function update()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/cart.php');
        }

        $quantities = $_POST['quantities'] ?? [];

        if (!is_array($quantities)) {
            $this->redirect('/cart.php');
        }

        foreach ($quantities as $productId => $quantity) {
            $productId = (int) $productId;
            $quantity = (int) $quantity;
            $product = $this->productModel->getProductById($productId);

            if ($product !== null) {
                $this->cartModel->update($productId, $quantity, (int) $product['stock']);
            }
        }

        $_SESSION['success_message'] = 'Đã cập nhật giỏ hàng.';
        $this->redirect('/cart.php');
    }

    public function remove()
    {
        $this->requireLogin();

        $productId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($productId > 0) {
            $this->cartModel->remove($productId);
            $_SESSION['success_message'] = 'Đã xóa sản phẩm khỏi giỏ hàng.';
        }

        $this->redirect('/cart.php');
    }

    public function placeOrder()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/cart.php');
        }

        $cart = $this->cartModel->getCart();
        if (empty($cart)) {
            $_SESSION['error_message'] = 'Giỏ hàng đang trống, chưa thể thanh toán.';
            $this->redirect('/cart.php');
        }

        $fullName = trim((string) ($_POST['full_name'] ?? ''));
        $phone = trim((string) ($_POST['phone'] ?? ''));
        $address = trim((string) ($_POST['address'] ?? ''));
        $paymentMethod = trim((string) ($_POST['payment_method'] ?? 'COD'));

        if ($fullName === '' || $phone === '' || $address === '') {
            $_SESSION['error_message'] = 'Vui lòng nhập đầy đủ họ tên, số điện thoại và địa chỉ.';
            $this->redirect('/cart.php');
        }

        $this->cartModel->clear();
        $_SESSION['success_message'] = 'Đặt hàng thành công bằng phương thức ' . htmlspecialchars($paymentMethod) . '.';
        $this->redirect('/cart.php');
    }

    private function requireLogin()
    {
        if (empty($_SESSION['user'])) {
            $_SESSION['auth_error'] = 'Bạn cần đăng nhập để sử dụng giỏ hàng.';
            $this->redirect('/login.php');
        }
    }

    private function buildCartItems($cart)
    {
        if (empty($cart)) {
            return [];
        }

        $products = $this->productModel->getProductsByIds(array_keys($cart));
        $cartItems = [];

        foreach ($products as $product) {
            $productId = (int) $product['id'];
            $quantity = (int) ($cart[$productId] ?? 0);

            if ($quantity <= 0) {
                continue;
            }

            $imagePath = !empty($product['image_path'])
                ? '/' . ltrim((string) $product['image_path'], '/')
                : '/image/empty.png';

            $product['quantity'] = $quantity;
            $product['image_path'] = $imagePath;
            $product['subtotal'] = (float) $product['price'] * $quantity;
            $cartItems[] = $product;
        }

        return $cartItems;
    }

    private function redirect($path)
    {
        header('Location: ' . $path);
        exit;
    }
}
