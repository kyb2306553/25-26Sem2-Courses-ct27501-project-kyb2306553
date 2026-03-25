<section class="page-detail py-5">
    <div class="container">
        <?php if ($product === null) { ?>
        <div class="alert alert-warning">
            Không tìm thấy sản phẩm. <a href="/products.php">Quay lại trang sản phẩm</a>
        </div>
        <?php } else {
            $imagePath = !empty($product['image_path'])
                ? '/' . ltrim((string) $product['image_path'], '/')
                : '/image/empty.png';
        ?>
        <div class="detail-card bg-white p-4 rounded shadow-sm">
            <div class="row g-4">
                <div class="col-md-5">
                    <img src="<?php echo htmlspecialchars($imagePath); ?>"
                        alt="<?php echo htmlspecialchars($product['name']); ?>" class="detail-img img-fluid rounded">
                </div>

                <div class="col-md-7">
                    <p class="mb-2 text-muted">
                        <a href="/index.php">Trang chủ</a> /
                        <a href="/products.php">Sản phẩm</a> /
                        <?php echo htmlspecialchars($product['name']); ?>
                    </p>

                    <h1 class="mb-3"><?php echo htmlspecialchars($product['name']); ?></h1>

                    <p class="mb-2"><strong>Danh mục:</strong>
                        <?php echo htmlspecialchars($product['category_name']); ?>
                    </p>

                    <p class="mb-2"><strong>Thương hiệu:</strong>
                        <?php echo !empty($product['brand_name']) ? htmlspecialchars($product['brand_name']) : 'Chưa cập nhật'; ?>
                    </p>

                    <p class="mb-2"><strong>Giá:</strong>
                        <span class="text-danger fw-bold">
                            <?php echo number_format((float) $product['price'], 0, ',', '.'); ?> đ
                        </span>
                    </p>

                    <p class="mb-3"><strong>Tồn kho:</strong>
                        <?php if ((int) $product['stock'] > 0) { ?>
                        Còn <?php echo (int) $product['stock']; ?> sản phẩm
                        <?php } else { ?>
                        Hết hàng
                        <?php } ?>
                    </p>

                    <div class="mb-4">
                        <h5>Mô tả</h5>
                        <p class="mb-0">
                            <?php echo !empty($product['description'])
                                    ? nl2br(htmlspecialchars((string) $product['description'])) //chuyen xuong dong va bao ve html
                                    : 'Sản phẩm chưa có mô tả.'; ?>
                        </p>
                    </div>

                    <?php if ((int) $product['stock'] > 0) { ?>
                    <form action="/cart.php?action=add" method="POST" class="row g-3 align-items-end">
                        <input type="hidden" name="product_id" value="<?php echo (int) $product['id']; ?>">

                        <div class="col-sm-4">
                            <label for="quantity" class="form-label">Số lượng</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" min="1"
                                max="<?php echo (int) $product['stock']; ?>" value="1">
                        </div>

                        <div class="col-sm-8 d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-dark">Thêm vào giỏ hàng</button>
                            <a href="/products.php" class="btn btn-outline-secondary">Quay lại</a>
                        </div>
                    </form>
                    <?php } else { ?>
                    <a href="/products.php" class="btn btn-outline-secondary">Quay lại</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>