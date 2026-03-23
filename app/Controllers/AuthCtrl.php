<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthCtrl
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

        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            $_SESSION['auth_error'] = 'Vui lòng nhập email và mật khẩu.';
            $this->redirect('/login.php');
        }

        $user = $this->userModel->findByEmail($email);

        if ($user === null || !password_verify($password, (string) $user['password_hash'])) {
            $_SESSION['auth_error'] = 'Email hoặc mật khẩu không đúng.';
            $this->redirect('/login.php');
        }

        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'full_name' => (string) $user['full_name'],
            'email' => (string) $user['email'],
            'role' => (string) $user['role'],
            'phone' => (string) $user['phone'],
        ];

        $_SESSION['auth_success'] = 'Đăng nhập thành công.';
        $this->redirect('/index.php');
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

        if ($fullName === '' || $email === '' || $phone === '' || $password === '') {
            $_SESSION['auth_error'] = 'Vui lòng nhập đầy đủ thông tin.';
            $this->redirect('/register.php');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['auth_error'] = 'Email không hợp lệ.';
            $this->redirect('/register.php');
        }

        if ($password !== $confirmPassword) {
            $_SESSION['auth_error'] = 'Mật khẩu nhập lại không khớp.';
            $this->redirect('/register.php');
        }

        if ($this->userModel->findByEmail($email) !== null) {
            $_SESSION['auth_error'] = 'Email này đã tồn tại.';
            $this->redirect('/register.php');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $created = $this->userModel->create($fullName, $email, $passwordHash, $phone, 'user');

        if (!$created) {
            $_SESSION['auth_error'] = 'Đăng ký thất bại.';
            $this->redirect('/register.php');
        }

        $_SESSION['auth_success'] = 'Đăng ký thành công. Mời bạn đăng nhập.';
        $this->redirect('/login.php');
    }

    public function logout()
    {
        unset($_SESSION['user']);
        $_SESSION['auth_success'] = 'Đã đăng xuất.';
        $this->redirect('/login.php');
    }

    private function redirect($path)
    {
        header('Location: ' . $path);
        exit;
    }
}
