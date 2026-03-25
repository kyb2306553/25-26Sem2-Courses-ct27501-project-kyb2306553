<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/index.php?url=admin">Admin</a></li>
                    <li class="breadcrumb-item active">Sửa sản phẩm</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning py-3">
                    <h5 class="card-title mb-0 text-dark">Chỉnh sửa sản phẩm: #<?php echo (int) $product['id']; ?></h5>
                </div>
                <div class="card-body p-4">
                    <form action="/index.php?url=admin/edit/<?php echo (int) $product['id']; ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="sesskey" value="<?php echo htmlspecialchars((string) $_SESSION['sesskey']); ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars((string) $product['name']); ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá bán (VNĐ)</label>
                                <input type="number" name="price" class="form-control" value="<?php echo (float) $product['price']; ?>" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số lượng tồn kho</label>
                                <input type="number" name="stock" class="form-control" value="<?php echo (int) $product['stock']; ?>" min="0" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Danh mục</label>
                                <select name="category_id" class="form-select" required>
                                    <?php foreach ($categories as $cat) : ?>
                                        <option value="<?php echo (int) $cat['id']; ?>" <?php echo (int) ($product['category_id'] ?? 0) === (int) $cat['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars((string) $cat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thương hiệu</label>
                                <select name="brand_id" class="form-select">
                                    <option value="">-- Chọn thương hiệu --</option>
                                    <?php foreach ($brands as $brand) : ?>
                                        <option value="<?php echo (int) $brand['id']; ?>" <?php echo (int) ($product['brand_id'] ?? 0) === (int) $brand['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars((string) $brand['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả sản phẩm</label>
                            <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars((string) ($product['description'] ?? '')); ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold d-block">Ảnh sản phẩm</label>
                            <div class="mb-2">
                                <img src="/<?php echo ltrim((string) ($product['image_path'] ?? 'image/empty.png'), '/'); ?>" alt="Current Image" class="img-thumbnail" style="height: 120px;">
                                <p class="small text-muted mt-1 mb-2">Ảnh hiện tại</p>
                            </div>
                            <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/*">
                            <div class="form-text">Để trống nếu bạn không muốn thay đổi ảnh.</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning px-4">Cập nhật</button>
                            <a href="/index.php?url=admin" class="btn btn-outline-secondary px-4">Hủy bỏ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
