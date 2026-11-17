<?php
require_once __DIR__ . '/../models/Item.php';
require_once __DIR__ . '/../helpers/AuthHelper.php';
require_once __DIR__ . '/../helpers/CsrfHelper.php';
require_once __DIR__ . '/../helpers/ViewHelper.php';

class ItemController {
    private Item $itemModel;

    public function __construct() {
        AuthHelper::requireLogin();
        $this->itemModel = new Item();
    }

    public function index(): void {
        $search = trim($_GET['search'] ?? '');
        $category = trim($_GET['category'] ?? '');
        $items = $this->itemModel->getAll($search, $category);

        $pageTitle = 'Manajemen Item / Data';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/items/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    public function create(): void {
        $pageTitle = 'Tambah Item Baru';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/items/create.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/index.php?page=items');
            exit;
        }

        if (!CsrfHelper::validateToken($_POST['csrf_token'] ?? '')) {
            ViewHelper::setFlash('error', 'Token CSRF tidak valid.');
            header('Location: ' . BASE_URL . '/index.php?page=items&action=create');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $category = trim($_POST['category'] ?? 'Umum');
        $status = trim($_POST['status'] ?? 'active');
        $description = trim($_POST['description'] ?? '');

        if (empty($title)) {
            ViewHelper::setFlash('error', 'Judul item wajib diisi.');
            header('Location: ' . BASE_URL . '/index.php?page=items&action=create');
            exit;
        }

        $userId = AuthHelper::user()['id'];
        $success = $this->itemModel->create($userId, $title, $category, $status, $description);

        if ($success) {
            ViewHelper::setFlash('success', 'Item berhasil ditambahkan!');
            header('Location: ' . BASE_URL . '/index.php?page=items');
            exit;
        } else {
            ViewHelper::setFlash('error', 'Gagal menyimpan item ke database.');
            header('Location: ' . BASE_URL . '/index.php?page=items&action=create');
            exit;
        }
    }

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $item = $this->itemModel->getById($id);

        if (!$item) {
            ViewHelper::setFlash('error', 'Data tidak ditemukan!');
            header('Location: ' . BASE_URL . '/index.php?page=items');
            exit;
        }

        $pageTitle = 'Edit Item: ' . $item['title'];
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/items/edit.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/index.php?page=items');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if (!CsrfHelper::validateToken($_POST['csrf_token'] ?? '')) {
            ViewHelper::setFlash('error', 'Token CSRF tidak valid.');
            header('Location: ' . BASE_URL . '/index.php?page=items&action=edit&id=' . $id);
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $category = trim($_POST['category'] ?? 'Umum');
        $status = trim($_POST['status'] ?? 'active');
        $description = trim($_POST['description'] ?? '');

        if (empty($title)) {
            ViewHelper::setFlash('error', 'Judul item wajib diisi.');
            header('Location: ' . BASE_URL . '/index.php?page=items&action=edit&id=' . $id);
            exit;
        }

        $success = $this->itemModel->update($id, $title, $category, $status, $description);

        if ($success) {
            ViewHelper::setFlash('success', 'Item berhasil diperbarui!');
            header('Location: ' . BASE_URL . '/index.php?page=items');
            exit;
        } else {
            ViewHelper::setFlash('error', 'Gagal memperbarui item.');
            header('Location: ' . BASE_URL . '/index.php?page=items&action=edit&id=' . $id);
            exit;
        }
    }

    public function delete(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/index.php?page=items');
            exit;
        }

        if (!CsrfHelper::validateToken($_POST['csrf_token'] ?? '')) {
            ViewHelper::setFlash('error', 'Token CSRF tidak valid.');
            header('Location: ' . BASE_URL . '/index.php?page=items');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $success = $this->itemModel->delete($id);

        if ($success) {
            ViewHelper::setFlash('success', 'Item berhasil dihapus.');
        } else {
            ViewHelper::setFlash('error', 'Gagal menghapus item.');
        }

        header('Location: ' . BASE_URL . '/index.php?page=items');
        exit;
    }
}
