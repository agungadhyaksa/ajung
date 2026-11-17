<?php
$currentUser = AuthHelper::user();
$activePage = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ViewHelper::escape($pageTitle ?? 'Portal') ?> - <?= APP_NAME ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

    <!-- Top Navigation Bar -->
    <header class="bg-indigo-600 text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-white text-indigo-600 font-bold rounded-lg flex items-center justify-center text-xl shadow">
                        A
                    </div>
                    <div>
                        <a href="<?= BASE_URL ?>/index.php?page=dashboard" class="text-xl font-bold tracking-tight hover:text-indigo-100 transition">
                            <?= APP_NAME ?>
                        </a>
                        <span class="text-xs text-indigo-200 block -mt-1">v<?= APP_VERSION ?></span>
                    </div>
                </div>

                <?php if ($currentUser): ?>
                <nav class="hidden md:flex space-x-1">
                    <a href="<?= BASE_URL ?>/index.php?page=dashboard" 
                       class="px-3 py-2 rounded-md text-sm font-medium transition <?= $activePage === 'dashboard' ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-500 hover:text-white' ?>">
                        Dashboard
                    </a>
                    <a href="<?= BASE_URL ?>/index.php?page=items" 
                       class="px-3 py-2 rounded-md text-sm font-medium transition <?= $activePage === 'items' ? 'bg-indigo-700 text-white' : 'text-indigo-100 hover:bg-indigo-500 hover:text-white' ?>">
                        Manajemen Item
                    </a>
                </nav>

                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-semibold text-white"><?= ViewHelper::escape($currentUser['username']) ?></div>
                        <div class="text-xs text-indigo-200 uppercase tracking-wider"><?= ViewHelper::escape($currentUser['role']) ?></div>
                    </div>
                    <a href="<?= BASE_URL ?>/index.php?page=logout" 
                       class="bg-indigo-700 hover:bg-rose-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition duration-150 shadow">
                        Keluar
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Flash Messages -->
        <?php if ($successMsg = ViewHelper::getFlash('success')): ?>
            <div class="mb-5 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0 text-emerald-500 font-bold">✓</div>
                    <div class="ml-3 text-sm text-emerald-800 font-medium">
                        <?= ViewHelper::escape($successMsg) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($errorMsg = ViewHelper::getFlash('error')): ?>
            <div class="mb-5 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0 text-rose-500 font-bold">✕</div>
                    <div class="ml-3 text-sm text-rose-800 font-medium">
                        <?= ViewHelper::escape($errorMsg) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
