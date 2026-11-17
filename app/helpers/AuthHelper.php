<?php

class AuthHelper {
    public static function check(): bool {
        return isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
    }

    public static function user(): ?array {
        return $_SESSION['user'] ?? null;
    }

    public static function requireLogin(): void {
        if (!self::check()) {
            $_SESSION['flash_error'] = 'Silakan login terlebih dahulu untuk mengakses halaman ini.';
            header('Location: ' . BASE_URL . '/index.php?page=login');
            exit;
        }
    }

    public static function login(array $userData): void {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => $userData['id'],
            'username' => $userData['username'],
            'email' => $userData['email'],
            'role' => $userData['role']
        ];
    }

    public static function logout(): void {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}
