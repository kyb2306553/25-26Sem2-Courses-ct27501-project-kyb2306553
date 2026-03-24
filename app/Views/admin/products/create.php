<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/index.php?url=admin">Admin</a></li>
                    <li class="breadcrumb-item active">Thêm sản phẩm</li>
                </ol>
            </nav>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="card-title mb-0">Thêm sản phẩm mới</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/index.php?url=admin/create" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập tên sản phẩm" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá bán (VNĐ)</label>
                                <input type="number" name="price" class="form-control" placeholder="Ví dụ: 500000" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số lượng tồn kho</label>
                                <input type="number" name="stock" class="form-control" value="0" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Danh mục</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thương hiệu</label>
                                <select name="brand_id" class="form-select">
                                    <option value="">-- Chọn thương hiệu --</option>
                                    <?php foreach ($brands as $brand): ?>
                                        <option value="<?php echo $brand['id']; ?>"><?php echo htmlspecialchars($brand['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả sản phẩm</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Nhập chi tiết về chất liệu, kích thước..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Ảnh sản phẩm</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                            <div class="form-text">Vui lòng chọn ảnh định dạng .jpg, .png hoặc .webp</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">Lưu sản phẩm</button>
                            <a href="/index.php?url=admin" class="btn btn-outline-secondary px-4">Hủy bỏ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>