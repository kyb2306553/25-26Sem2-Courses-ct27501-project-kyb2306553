<div class="container mt-5 pt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Hệ thống Quản trị Sản phẩm</h2>
        <a href="/index.php?url=admin/create" class="btn btn-success"> + Thêm sản phẩm mới</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-info alert-dismissible fade show">
            <?php 
                if($_GET['msg'] == 'success') echo "Đã thêm sản phẩm thành công!";
                if($_GET['msg'] == 'updated') echo "Đã cập nhật sản phẩm!";
                if($_GET['msg'] == 'deleted') echo "Đã xóa sản phẩm khỏi hệ thống!";
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="table-responsive shadow-sm card">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th style="width: 80px;">Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá bán</th>
                    <th>Kho</th>
                    <th>Danh mục</th>
                    <th class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><strong>#<?php echo $p['id']; ?></strong></td>
                    <td>
                        <img src="/<?php echo ltrim($p['image_path'] ?? 'image/empty.png', '/'); ?>" 
                            alt="" class="rounded border" width="60" height="60" style="object-fit: cover;">
                    </td>
                    <td>
                        <div class="fw-bold"><?php echo htmlspecialchars($p['name']); ?></div>
                        <small class="text-muted"><?php echo htmlspecialchars($p['brand_name'] ?? 'No brand'); ?></small>
                    </td>
                    <td class="text-danger fw-bold"><?php echo number_format((float)$p['price'], 0, ',', '.'); ?>đ</td>
                    <td>
                        <span class="badge <?php echo $p['stock'] > 5 ? 'bg-success' : 'bg-danger'; ?>">
                            <?php echo $p['stock']; ?> sp
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($p['category_name']); ?></td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="/index.php?url=admin/edit/<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-warning">Sửa</a>
                            <a href="/index.php?url=admin/delete/<?php echo $p['id']; ?>" 
                                class="btn btn-sm btn-outline-danger" 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">Xóa</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>