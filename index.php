<?php
// Entry Point / Front Controller
// Proyek Web PHP: Ajung Portal

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/helpers/AuthHelper.php';
require_once __DIR__ . '/app/helpers/CsrfHelper.php';
require_once __DIR__ . '/app/helpers/ViewHelper.php';

// Inisialisasi Database Connection saat pertama kali aplikasi dibuka
Database::getConnection();

// Router Sederhana Berbasis Query Param 'page' dan 'action'
$page = $_GET['page'] ?? (AuthHelper::check() ? 'dashboard' : 'login');
$action = $_GET['action'] ?? 'index';

switch ($page) {
    case 'login':
        require_once __DIR__ . '/app/controllers/AuthController.php';
        (new AuthController())->showLogin();
        break;

    case 'login_process':
        require_once __DIR__ . '/app/controllers/AuthController.php';
        (new AuthController())->login();
        break;

    case 'logout':
        require_once __DIR__ . '/app/controllers/AuthController.php';
        (new AuthController())->logout();
        break;

    case 'dashboard':
        require_once __DIR__ . '/app/controllers/DashboardController.php';
        (new DashboardController())->index();
        break;

    case 'items':
        require_once __DIR__ . '/app/controllers/ItemController.php';
        $controller = new ItemController();

        if ($action === 'create') {
            $controller->create();
        } elseif ($action === 'store') {
            $controller->store();
        } elseif ($action === 'edit') {
            $controller->edit();
        } elseif ($action === 'update') {
            $controller->update();
        } elseif ($action === 'delete') {
            $controller->delete();
        } else {
            $controller->index();
        }
        break;

    default:
        // Redirect ke dashboard jika sudah login, atau ke login jika belum
        if (AuthHelper::check()) {
            header('Location: ' . BASE_URL . '/index.php?page=dashboard');
        } else {
            header('Location: ' . BASE_URL . '/index.php?page=login');
        }
        exit;
}
