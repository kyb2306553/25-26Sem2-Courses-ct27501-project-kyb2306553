<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function showLogin()
    {
        $errorMessage = $_SESSION['auth_error'] ?? null;
        $successMessage = $_SESSION['auth_success'] ?? null;
        unset($_SESSION['auth_error'], $_SESSION['auth_success']);

        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/auth/login.php';
        require_once __DIR__ . '/../Views/footer.php';
    }

    public function showRegister()
    {
        $errorMessage = $_SESSION['auth_error'] ?? null;
        $successMessage = $_SESSION['auth_success'] ?? null;
        unset($_SESSION['auth_error'], $_SESSION['auth_success']);

        require_once __DIR__ . '/../Views/header.php';
        require_once __DIR__ . '/../Views/auth/register.php';
        require_once __DIR__ . '/../Views/footer.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login.php');
        }

        $phone = trim((string) ($_POST['phone'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if ($phone === '' || $password === '') {
            $_SESSION['auth_error'] = 'Vui lòng nhập số điện thoại và mật khẩu.';
            $this->redirect('/login.php');
        }

        $user = $this->userModel->findByPhone($phone);

        if ($user === null || !password_verify($password, (string) $user['password_hash'])) {
            $_SESSION['auth_error'] = 'Số điện thoại hoặc mật khẩu không đúng.';
            $this->redirect('/login.php');
        }

        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'full_name' => (string) $user['full_name'],
            'email' => $user['email'] !== null ? (string) $user['email'] : null,
            'role' => (string) $user['role'],
            'phone' => (string) $user['phone'],
        ];

        $_SESSION['auth_success'] = 'Đăng nhập thành công.';
        if ($user['role'] === 'admin') {
            $this->redirect('/index.php?url=admin');
        } else {
            $this->redirect('/index.php');
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register.php');
        }

        $fullName = trim((string) ($_POST['full_name'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $phone = trim((string) ($_POST['phone'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

        if ($fullName === '' || $phone === '' || $password === '') {
            $_SESSION['auth_error'] = 'Vui lòng nhập họ tên, số điện thoại và mật khẩu.';
            $this->redirect('/register.php');
        }

        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['auth_error'] = 'Email không hợp lệ.';
            $this->redirect('/register.php');
        }

        if (!preg_match('/^[0-9+\-\s().]{8,20}$/', $phone)) {
            $_SESSION['auth_error'] = 'Số điện thoại không hợp lệ.';
            $this->redirect('/register.php');
        }

        if ($password !== $confirmPassword) {
            $_SESSION['auth_error'] = 'Mật khẩu nhập lại không khớp.';
            $this->redirect('/register.php');
        }

        if ($email !== '' && $this->userModel->findByEmail($email) !== null) {
            $_SESSION['auth_error'] = 'Email này đã tồn tại.';
            $this->redirect('/register.php');
        }

        if ($this->userModel->phoneExists($phone)) {
            $_SESSION['auth_error'] = 'Số điện thoại này đã tồn tại.';
            $this->redirect('/register.php');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $created = $this->userModel->create($fullName, $email, $passwordHash, $phone, 'user');

        if (!$created) {
            $_SESSION['auth_error'] = 'Đăng ký thất bại.';
            $this->redirect('/register.php');
        }

        $_SESSION['auth_success'] = 'Đăng ký thành công. Mời bạn đăng nhập bằng số điện thoại.';
        $this->redirect('/login.php');
    }

    public function logout()
    {
        unset($_SESSION['user'], $_SESSION['cart']);
        session_regenerate_id(true);
        $_SESSION['auth_success'] = 'Đã đăng xuất.';
        $this->redirect('/login.php');
    }

    private function redirect($path)
    {
        header('Location: ' . $path);
        exit;
    }
}
