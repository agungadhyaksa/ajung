<?php
// Konfigurasi Umum Aplikasi

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('APP_NAME', 'Ajung Portal');
define('APP_VERSION', '1.0.0');

// Deteksi base URL secara dinamis
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
$protocol = $isHttps ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';

$rawScriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
if ($rawScriptDir === '.' || $rawScriptDir === '/' || $rawScriptDir === '\\') {
    $scriptDir = '';
} else {
    $scriptDir = '/' . trim($rawScriptDir, '/\\');
}

define('BASE_URL', $protocol . $host . $scriptDir);

// Tipe Driver Database: 'sqlite' atau 'mysql'
define('DB_DRIVER', 'sqlite');

// Konfigurasi SQLite
define('SQLITE_PATH', __DIR__ . '/../database/app.sqlite');

// Konfigurasi MySQL (opsional jika beralih ke MySQL XAMPP)
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'ajung_portal');
define('DB_USER', 'root');
define('DB_PASS', '');
