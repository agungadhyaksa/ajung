<div class="space-y-6">

    <!-- Top Greeting Banner -->
    <div class="bg-gradient-to-r from-indigo-700 to-indigo-900 rounded-2xl p-6 text-white shadow-lg flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold tracking-tight">Halo, <?= ViewHelper::escape($currentUser['username']) ?>! 👋</h2>
            <p class="text-indigo-200 text-sm mt-1">Selamat datang di Panel Manajemen Ajung Portal. Pantau dan kelola data proyek Anda di sini.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?= BASE_URL ?>/index.php?page=items&action=create" 
               class="bg-white text-indigo-700 hover:bg-indigo-50 font-semibold px-4 py-2.5 rounded-xl text-sm shadow transition duration-150 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Data Baru
            </a>
            <a href="<?= BASE_URL ?>/index.php?page=items" 
               class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium px-4 py-2.5 rounded-xl text-sm border border-indigo-400 transition duration-150">
                Lihat Semua Data
            </a>
        </div>
    </div>

    <!-- Metric Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Items -->
        <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Item</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= $stats['total'] ?></h3>
                <p class="text-xs text-slate-400 mt-0.5">Keseluruhan entitas data</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg">
                📦
            </div>
        </div>

        <!-- Active Items -->
        <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Status Aktif</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= $stats['active'] ?></h3>
                <p class="text-xs text-slate-400 mt-0.5">Berjalan aktif</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                ⚡
            </div>
        </div>

        <!-- Pending Items -->
        <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider">Menunggu</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= $stats['pending'] ?></h3>
                <p class="text-xs text-slate-400 mt-0.5">Perlu tindak lanjut</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg">
                ⏳
            </div>
        </div>

        <!-- Completed Items -->
        <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Selesai</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= $stats['completed'] ?></h3>
                <p class="text-xs text-slate-400 mt-0.5">Terselesaikan</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg">
                ✅
            </div>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800">Aktivitas Item Terbaru</h3>
                <p class="text-xs text-slate-500">5 entri data terakhir yang dimasukkan ke sistem</p>
            </div>
            <a href="<?= BASE_URL ?>/index.php?page=items" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                Lihat Lengkap &rarr;
            </a>
        </div>

        <?php if (empty($recentItems)): ?>
            <div class="p-8 text-center text-slate-400 text-sm">
                Belum ada data item. Klik tombol "Tambah Data Baru" di atas untuk menambahkan item pertama Anda.
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Judul Item</th>
                            <th class="px-6 py-3">Kategori</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Dibuat Oleh</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($recentItems as $item): ?>
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-3.5 font-mono text-xs text-slate-400">#<?= $item['id'] ?></td>
                            <td class="px-6 py-3.5 font-medium text-slate-800">
                                <?= ViewHelper::escape($item['title']) ?>
                                <?php if (!empty($item['description'])): ?>
                                    <span class="block text-xs text-slate-400 truncate max-w-xs"><?= ViewHelper::escape($item['description']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-3.5">
                                <span class="bg-slate-100 text-slate-700 text-xs px-2 py-0.5 rounded font-medium">
                                    <?= ViewHelper::escape($item['category']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-3.5">
                                <?= ViewHelper::statusBadge($item['status']) ?>
                            </td>
                            <td class="px-6 py-3.5 text-xs text-slate-500">
                                <?= ViewHelper::escape($item['author'] ?? 'Admin') ?>
                            </td>
                            <td class="px-6 py-3.5 text-right">
                                <a href="<?= BASE_URL ?>/index.php?page=items&action=edit&id=<?= $item['id'] ?>" 
                                   class="text-indigo-600 hover:text-indigo-900 font-medium text-xs mr-2">Edit</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</div>
