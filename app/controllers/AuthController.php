<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/AuthHelper.php';
require_once __DIR__ . '/../helpers/CsrfHelper.php';
require_once __DIR__ . '/../helpers/ViewHelper.php';

class AuthController {
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function showLogin(): void {
        if (AuthHelper::check()) {
            header('Location: ' . BASE_URL . '/index.php?page=dashboard');
            exit;
        }
        require_once __DIR__ . '/../../views/auth/login.php';
    }

    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/index.php?page=login');
            exit;
        }

        if (!CsrfHelper::validateToken($_POST['csrf_token'] ?? '')) {
            ViewHelper::setFlash('error', 'Token keamanan CSRF tidak valid. Silakan coba lagi.');
            header('Location: ' . BASE_URL . '/index.php?page=login');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            ViewHelper::setFlash('error', 'Username dan Password wajib diisi.');
            header('Location: ' . BASE_URL . '/index.php?page=login');
            exit;
        }

        $user = $this->userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            AuthHelper::login($user);
            ViewHelper::setFlash('success', 'Selamat datang kembali, ' . htmlspecialchars($user['username']) . '!');
            header('Location: ' . BASE_URL . '/index.php?page=dashboard');
            exit;
        }

        ViewHelper::setFlash('error', 'Username atau Password salah!');
        header('Location: ' . BASE_URL . '/index.php?page=login');
        exit;
    }

    public function logout(): void {
        AuthHelper::logout();
        session_start();
        ViewHelper::setFlash('success', 'Anda telah berhasil keluar (logout).');
        header('Location: ' . BASE_URL . '/index.php?page=login');
        exit;
    }
}
