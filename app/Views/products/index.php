<section class="page-banner">
    <img src="/image/pro_banner.jpg" alt="Banner sản phẩm">
    <div class="page-banner__content">
        <h1>Wear the Brand. Live the Sport.</h1>
        <p>Khám phá các sản phẩm nổi bật dành cho phong cách thể thao của bạn.</p>
    </div>
</section>

<section class="page-products py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <div>
                <h2 class="page-title mb-1">Tất cả sản phẩm</h2>
                <p class="section-subtitle">Hiển thị <strong><?php echo $totalProducts; ?></strong> sản phẩm trong cửa hàng.</p>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($products)) {
                foreach ($products as $product) {
                    $imagePath = $product['image_path'];

                    if (empty($imagePath)) {
                        $imagePath = '/image/empty.png';
                    } else {
                        $imagePath = '/' . ltrim($imagePath, '/');
                    }
            ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card prod-card h-100">
                            <img src="<?php echo htmlspecialchars($imagePath); ?>"
                                alt="<?php echo htmlspecialchars($product['name']); ?>" class="prod-img">

                            <div class="card-body d-flex flex-column">
                                <p class="prod-meta mb-1">
                                    <?php echo htmlspecialchars($product['category_name']); ?>
                                </p>
                                <p class="prod-meta mb-2">
                                    Thương hiệu:
                                    <?php echo !empty($product['brand_name']) ? htmlspecialchars($product['brand_name']) : 'Chưa cập nhật'; ?>
                                </p>
                                <h5 class="prod-name">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </h5>
                                <p class="prod-price">
                                    <?php echo number_format((float) $product['price'], 0, ',', '.'); ?> đ
                                </p>
                                <p class="text-muted small mb-3">
                                    Tồn kho: <?php echo (int) $product['stock']; ?>
                                </p>
                                <a href="/product-detail.php?id=<?php echo (int) $product['id']; ?>"
                                    class="btn btn-dark prod-btn mt-auto">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="col-12">
                    <div class="alert alert-warning mb-0">
                        Hiện chưa có sản phẩm nào để hiển thị.
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
