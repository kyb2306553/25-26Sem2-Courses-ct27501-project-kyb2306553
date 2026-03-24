<?php

use App\Models\CartModel;

$cartModel = new CartModel();
$cartCount = $cartModel->getTotalQuantity();
$currentPage = basename($_SERVER['PHP_SELF'] ?? '');
$currentUser = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportify - Move Your Style</title>
    <link rel="icon" href="/image/logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <header class="bg-white shadow-sm fixed-navbar">
        <div class="container py-3">
            <div class="simple-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                <a class="navbar-brand d-flex align-items-center" href="/index.php">
                    <img src="/image/logo.png" alt="Logo" height="40" width="40" class="me-2">
                    <span>Sportify</span>
                </a>

                <nav class="d-flex flex-wrap gap-3 align-items-center">
                    <a class="nav-link <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>"
                        href="/index.php">Trang chủ</a>
                    <a class="nav-link <?php echo in_array($currentPage, ['products.php', 'product-detail.php'], true) ? 'active' : ''; ?>"
                        href="/products.php">Sản phẩm</a>
                    
                    <?php if ($currentUser && ($currentUser['role'] ?? '') === 'admin') : ?>
                        <a class="nav-link <?php echo (strpos($currentUrl, 'admin') === 0) ? 'active' : ''; ?> text-danger fw-bold" 
                            href="/index.php?url=admin">
                            <i class="bi bi-gear-fill"></i> QUẢN TRỊ
                        </a>
                    <?php endif; ?>

                    <a class="nav-link <?php echo $currentPage === 'about.php' ? 'active' : ''; ?>" href="/about.php">Về
                        chúng tôi</a>
                    <a class="nav-link <?php echo $currentPage === 'cart.php' ? 'active' : ''; ?>" href="/cart.php">Giỏ
                        hàng (<?php echo $cartCount; ?>)</a>

                    <?php if ($currentUser !== null) { ?>
                        <span class="text-muted small">Xin chào,
                            <?php echo htmlspecialchars((string) $currentUser['full_name']); ?></span>
                        <a class="nav-link" href="/logout.php">Đăng xuất</a>
                    <?php } else { ?>
                        <a class="nav-link <?php echo in_array($currentPage, ['login.php', 'register.php'], true) ? 'active' : ''; ?>"
                            href="/login.php">Đăng nhập</a>
                    <?php } ?>
                </nav>
            </div>
        </div>
    </header>