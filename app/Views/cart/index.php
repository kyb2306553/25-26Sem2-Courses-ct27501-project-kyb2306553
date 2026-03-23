<section class="page-cart py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h1 class="page-title mb-1">Trang thanh toán</h1>
                <p class="text-muted mb-0">Kiểm tra giỏ hàng, chỉnh số lượng và hoàn tất đơn hàng.</p>
            </div>
            <a href="/products.php" class="btn btn-outline-dark">Chỉnh sửa sản phẩm</a>
        </div>

        <?php if (!empty($successMessage)) { ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php } ?>

        <?php if (!empty($errorMessage)) { ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php } ?>

        <?php if (empty($cartItems)) { ?>
            <div class="empty-card text-center py-5">
                <h3 class="mb-3">Giỏ hàng đang trống</h3>
                <p class="text-muted mb-4">Bạn chưa thêm sản phẩm nào để thanh toán.</p>
                <a href="/products.php" class="btn btn-dark px-4">Đi đến trang sản phẩm</a>
            </div>
        <?php } else { ?>
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="cart-card bg-white shadow-sm rounded-4 p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                            <h4 class="mb-0">Sản phẩm trong giỏ</h4>
                            <span class="text-muted"><?php echo (int) $cartCount; ?> sản phẩm</span>
                        </div>

                        <form action="/cart.php?action=update" method="POST">
                            <div class="table-responsive">
                                <table class="table align-middle cart-table">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Đơn giá</th>
                                            <th>Số lượng</th>
                                            <th>Tạm tính</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cartItems as $item) { ?>
                                            <tr>
                                                <td>
                                                    <div class="cart-item d-flex align-items-center gap-3">
                                                        <img src="<?php echo htmlspecialchars($item['image_path']); ?>"
                                                            alt="<?php echo htmlspecialchars($item['name']); ?>"
                                                            class="cart-img">
                                                        <div>
                                                            <h6 class="mb-1"><?php echo htmlspecialchars($item['name']); ?></h6>
                                                            <p class="mb-0 text-muted small">
                                                                <?php echo htmlspecialchars($item['category_name']); ?>
                                                                <?php if (!empty($item['brand_name'])) { ?>
                                                                    • <?php echo htmlspecialchars($item['brand_name']); ?>
                                                                <?php } ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo number_format((float) $item['price'], 0, ',', '.'); ?> đ</td>
                                                <td>
                                                    <input type="number" class="form-control qty-input"
                                                        name="quantities[<?php echo (int) $item['id']; ?>]"
                                                        min="0" max="<?php echo (int) $item['stock']; ?>"
                                                        value="<?php echo (int) $item['quantity']; ?>">
                                                </td>
                                                <td><?php echo number_format((float) $item['subtotal'], 0, ',', '.'); ?> đ</td>
                                                <td class="text-end">
                                                    <a href="/cart.php?action=remove&id=<?php echo (int) $item['id']; ?>"
                                                        class="btn btn-sm btn-outline-danger">Xóa</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-dark">Cập nhật giỏ hàng</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="cart-card bg-white shadow-sm rounded-4 p-4 mb-4">
                        <h4 class="mb-3">Thông tin thanh toán</h4>
                        <form action="/cart.php?action=place-order" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" name="full_name" class="form-control" placeholder="Nhập họ tên khách hàng">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Địa chỉ giao hàng</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Nhập địa chỉ nhận hàng"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phương thức thanh toán</label>
                                <select name="payment_method" class="form-select">
                                    <option value="COD">Thanh toán khi nhận hàng</option>
                                    <option value="Banking">Chuyển khoản</option>
                                    <option value="Momo">Ví điện tử</option>
                                </select>
                            </div>

                            <div class="summary-card mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tổng sản phẩm</span>
                                    <strong><?php echo (int) $cartCount; ?></strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Tổng thanh toán</span>
                                    <strong class="text-danger"><?php echo number_format((float) $cartTotal, 0, ',', '.'); ?> đ</strong>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-dark w-100">Xác nhận thanh toán</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
