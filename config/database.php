<?php
require_once __DIR__ . '/config.php';

class Database {
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO {
        if (self::$pdo === null) {
            try {
                if (DB_DRIVER === 'sqlite') {
                    $dbDir = dirname(SQLITE_PATH);
                    if (!is_dir($dbDir)) {
                        mkdir($dbDir, 0777, true);
                    }
                    self::$pdo = new PDO('sqlite:' . SQLITE_PATH);
                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    
                    // Inisialisasi skema & demo data otomatis jika file baru dibuat
                    self::initSqliteTables();
                } else {
                    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
                    self::$pdo = new PDO($dsn, DB_USER, DB_PASS);
                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                }
            } catch (PDOException $e) {
                die("Koneksi Database Gagal: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    private static function initSqliteTables(): void {
        $sql = "
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username VARCHAR(50) NOT NULL UNIQUE,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(20) DEFAULT 'user',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS items (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                title VARCHAR(150) NOT NULL,
                category VARCHAR(50) NOT NULL,
                status VARCHAR(20) DEFAULT 'active',
                description TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
        ";
        self::$pdo->exec($sql);

        // Tambah user demo admin jika belum ada
        $check = self::$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        if ($check == 0) {
            $hashedPassword = password_hash('admin123', PASSWORD_BCRYPT);
            $stmt = self::$pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute(['admin', 'admin@ajung.local', $hashedPassword, 'admin']);

            // Tambahkan beberapa sampel item
            $sampleItems = [
                [1, 'Dokumentasi Sistem Ajung', 'Dokumentasi', 'active', 'Dokumen PRD dan arsitektur awal sistem.'],
                [1, 'Konfigurasi Server Lokal', 'Infrastruktur', 'active', 'Setup server PHP built-in dan koneksi SQLite.'],
                [1, 'Review UI Dashboard', 'Desain', 'pending', 'Memastikan tampilan responsive di layar desktop dan mobile.']
            ];
            $stmtItem = self::$pdo->prepare("INSERT INTO items (user_id, title, category, status, description) VALUES (?, ?, ?, ?, ?)");
            foreach ($sampleItems as $item) {
                $stmtItem->execute($item);
            }
        }
    }
}
