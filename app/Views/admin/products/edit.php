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
                    <h5 class="card-title mb-0 text-dark">Chỉnh sửa sản phẩm: #<?php echo $product['id']; ?></h5>
                </div>
                <div class="card-body p-4">
                    <form action="/index.php?url=admin/edit/<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" 
                                value="<?php echo htmlspecialchars($product['name']); ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá bán (VNĐ)</label>
                                <input type="number" name="price" class="form-control" 
                                    value="<?php echo (int)$product['price']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số lượng tồn kho</label>
                                <input type="number" name="stock" class="form-control" 
                                    value="<?php echo $product['stock']; ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Danh mục</label>
                                <select name="category_id" class="form-select" required>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>" 
                                            <?php echo ($product['category_name'] == $cat['name']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thương hiệu</label>
                                <select name="brand_id" class="form-select">
                                    <?php foreach ($brands as $brand): ?>
                                        <option value="<?php echo $brand['id']; ?>"
                                            <?php echo ($product['brand_name'] == $brand['name']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($brand['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả sản phẩm</label>
                            <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold d-block">Ảnh sản phẩm</label>
                            <div class="mb-2">
                                <img src="/<?php echo ltrim($product['image_path'] ?? 'image/empty.png', '/'); ?>" 
                                    alt="Current Image" class="img-thumbnail" style="height: 120px;">
                                <p class="small text-muted mt-1">Ảnh hiện tại</p>
                            </div>
                            <input type="file" name="image" class="form-control" accept="image/*">
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