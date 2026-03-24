<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="auth-card bg-white p-4 rounded shadow-sm mx-auto">
            <h1 class="mb-4 text-center">Đăng nhập</h1>

            <?php if (!empty($successMessage)) { ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php } ?>

            <?php if (!empty($errorMessage)) { ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php } ?>

            <form action="/login.php?action=login" method="POST">
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-dark w-100">Đăng nhập</button>
            </form>

            <p class="text-center mt-3 mb-0">
                Chưa có tài khoản? <a href="/register.php">Đăng ký</a>
            </p>
        </div>
    </div>
</section>
