<div class="container mt-5 pt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Hệ thống Quản trị Sản phẩm</h2>
        <a href="/index.php?url=admin/create" class="btn btn-success">+ Thêm sản phẩm mới</a>
    </div>

    <?php if (!empty($messageKey)) : ?>
        <div class="alert alert-info alert-dismissible fade show">
            <?php
            if ($messageKey === 'success') {
                echo 'Đã thêm sản phẩm thành công.';
            } elseif ($messageKey === 'updated') {
                echo 'Đã cập nhật sản phẩm.';
            } elseif ($messageKey === 'deleted') {
                echo 'Đã xóa sản phẩm khỏi hệ thống.';
            } elseif ($messageKey === 'notfound') {
                echo 'Không tìm thấy sản phẩm.';
            } else {
                echo 'Thao tác chưa thành công.';
            }
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
                <?php foreach ($products as $p) : ?>
                    <tr>
                        <td><strong>#<?php echo (int) $p['id']; ?></strong></td>
                        <td>
                            <img src="/<?php echo ltrim((string) ($p['image_path'] ?? 'image/empty.png'), '/'); ?>" alt="" class="rounded border" width="60" height="60" style="object-fit: cover;">
                        </td>
                        <td>
                            <div class="fw-bold"><?php echo htmlspecialchars((string) $p['name']); ?></div>
                            <small class="text-muted"><?php echo htmlspecialchars((string) ($p['brand_name'] ?? 'No brand')); ?></small>
                        </td>
                        <td class="text-danger fw-bold"><?php echo number_format((float) $p['price'], 0, ',', '.'); ?>đ</td>
                        <td>
                            <span class="badge <?php echo (int) $p['stock'] > 5 ? 'bg-success' : 'bg-danger'; ?>">
                                <?php echo (int) $p['stock']; ?> sp
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars((string) $p['category_name']); ?></td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="/index.php?url=admin/edit/<?php echo (int) $p['id']; ?>" class="btn btn-sm btn-outline-warning">Sửa</a>
                                <form action="/index.php?url=admin/delete/<?php echo (int) $p['id']; ?>" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
