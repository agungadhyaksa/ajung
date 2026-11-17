<?php
require_once __DIR__ . '/../models/Item.php';
require_once __DIR__ . '/../helpers/AuthHelper.php';
require_once __DIR__ . '/../helpers/ViewHelper.php';

class DashboardController {
    private Item $itemModel;

    public function __construct() {
        AuthHelper::requireLogin();
        $this->itemModel = new Item();
    }

    public function index(): void {
        $stats = $this->itemModel->getStats();
        $recentItems = $this->itemModel->getRecent(5);
        $currentUser = AuthHelper::user();

        $pageTitle = 'Dashboard Utama';
        require_once __DIR__ . '/../../views/layouts/header.php';
        require_once __DIR__ . '/../../views/dashboard/index.php';
        require_once __DIR__ . '/../../views/layouts/footer.php';
    }
}
