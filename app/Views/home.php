<section class="hero">
    <img src="/image/banner.jpg" alt="Banner">

    <div class="hero__content">
        <h1>Sportify</h1>
        <p>Phong cách thể thao hiện đại</p>
        <a href="/products.php" class="hero__btn">Khám phá</a>
    </div>
</section>

<section class="section-featured py-5">
    <div class="container">
        <div class="row mb-4 align-items-center">
            <div class="col-md-8">
                <h2 class="section-title">Sản phẩm nổi bật</h2>
                <p class="section-subtitle">Một số sản phẩm dành cho bạn</p>
            </div>
        </div>

        <div class="row">
            <?php
            if (!empty($featuredProducts)) {
                foreach ($featuredProducts as $product) {
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
                                    <?php
                                    if (!empty($product['brand_name'])) {
                                        echo htmlspecialchars($product['brand_name']);
                                    } else {
                                        echo 'Chưa cập nhật';
                                    }
                                    ?>
                                </p>

                                <h5 class="prod-name">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </h5>

                                <p class="prod-price">
                                    <?php echo number_format((float) $product['price'], 0, ',', '.'); ?> đ
                                </p>

                                <a href="/product-detail.php?id=<?php echo (int) $product['id']; ?>"
                                    class="btn btn-dark prod-btn mt-auto">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="col-12">
                    <div class="alert alert-warning">
                        Chưa có sản phẩm để hiển thị.
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>
