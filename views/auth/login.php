<?php
$pageTitle = 'Login Akun';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
        <!-- Card Header -->
        <div class="bg-indigo-600 px-8 py-7 text-center text-white">
            <div class="inline-flex w-14 h-14 bg-white text-indigo-600 rounded-2xl items-center justify-center font-bold text-2xl shadow-md mb-3">
                A
            </div>
            <h1 class="text-2xl font-bold"><?= APP_NAME ?></h1>
            <p class="text-indigo-200 text-sm mt-1">Sistem Manajemen & Portal Data PHP</p>
        </div>

        <div class="p-8">
            <!-- Flash Notification -->
            <?php if ($successMsg = ViewHelper::getFlash('success')): ?>
                <div class="mb-4 bg-emerald-50 border border-emerald-300 text-emerald-800 text-sm px-4 py-3 rounded-lg">
                    <?= ViewHelper::escape($successMsg) ?>
                </div>
            <?php endif; ?>

            <?php if ($errorMsg = ViewHelper::getFlash('error')): ?>
                <div class="mb-4 bg-rose-50 border border-rose-300 text-rose-800 text-sm px-4 py-3 rounded-lg">
                    <?= ViewHelper::escape($errorMsg) ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="<?= BASE_URL ?>/index.php?page=login_process" method="POST" class="space-y-5">
                <?= CsrfHelper::getTokenInput() ?>

                <div>
                    <label for="username" class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                    <input type="text" id="username" name="username" required autofocus
                           value="admin"
                           class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm text-slate-800"
                           placeholder="Masukkan username">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                           value="admin123"
                           class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm text-slate-800"
                           placeholder="Masukkan password">
                </div>

                <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-3 text-xs text-indigo-900 leading-relaxed">
                    <span class="font-semibold block mb-0.5">Akun Demo Default:</span>
                    Username: <code class="bg-white px-1.5 py-0.5 rounded text-indigo-700 font-mono">admin</code> | 
                    Password: <code class="bg-white px-1.5 py-0.5 rounded text-indigo-700 font-mono">admin123</code>
                </div>

                <button type="submit" 
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg shadow hover:shadow-md transition duration-150 text-sm">
                    Masuk ke Sistem
                </button>
            </form>

            <div class="mt-6 text-center text-xs text-slate-400">
                Lokasi: <span class="font-mono">C:/agung/ajung</span>
            </div>
        </div>
    </div>

</body>
</html>
