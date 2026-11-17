<div class="space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Manajemen Data & Item</h2>
            <p class="text-slate-500 text-sm mt-0.5">Kelola, cari, dan perbarui data yang tersimpan di sistem.</p>
        </div>
        <a href="<?= BASE_URL ?>/index.php?page=items&action=create" 
           class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2.5 rounded-xl text-sm shadow transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Data Baru
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-sm">
        <form action="<?= BASE_URL ?>/index.php" method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="hidden" name="page" value="items">

            <div class="flex-grow">
                <input type="text" name="search" value="<?= ViewHelper::escape($_GET['search'] ?? '') ?>" 
                       placeholder="Cari berdasarkan judul atau deskripsi..." 
                       class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div class="w-full sm:w-48">
                <select name="category" class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                    <option value="">Semua Kategori</option>
                    <option value="Dokumentasi" <?= ($_GET['category'] ?? '') === 'Dokumentasi' ? 'selected' : '' ?>>Dokumentasi</option>
                    <option value="Infrastruktur" <?= ($_GET['category'] ?? '') === 'Infrastruktur' ? 'selected' : '' ?>>Infrastruktur</option>
                    <option value="Desain" <?= ($_GET['category'] ?? '') === 'Desain' ? 'selected' : '' ?>>Desain</option>
                    <option value="Pengembangan" <?= ($_GET['category'] ?? '') === 'Pengembangan' ? 'selected' : '' ?>>Pengembangan</option>
                    <option value="Umum" <?= ($_GET['category'] ?? '') === 'Umum' ? 'selected' : '' ?>>Umum</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    Cari
                </button>
                <?php if (!empty($_GET['search']) || !empty($_GET['category'])): ?>
                    <a href="<?= BASE_URL ?>/index.php?page=items" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-3 py-2 rounded-lg text-sm font-medium transition flex items-center">
                        Reset
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm overflow-hidden">
        <?php if (empty($items)): ?>
            <div class="p-12 text-center">
                <div class="w-12 h-12 text-3xl mx-auto mb-3">🔍</div>
                <h4 class="font-semibold text-slate-700">Tidak ada data ditemukan</h4>
                <p class="text-sm text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau tambahkan item baru.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3.5">ID</th>
                            <th class="px-6 py-3.5">Judul & Deskripsi</th>
                            <th class="px-6 py-3.5">Kategori</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5">Dibuat Oleh</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php foreach ($items as $item): ?>
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4 font-mono text-xs text-slate-400">#<?= $item['id'] ?></td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-800 text-base"><?= ViewHelper::escape($item['title']) ?></span>
                                <?php if (!empty($item['description'])): ?>
                                    <p class="text-xs text-slate-400 mt-0.5 line-clamp-1"><?= ViewHelper::escape($item['description']) ?></p>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 text-slate-700 text-xs px-2.5 py-1 rounded font-medium">
                                    <?= ViewHelper::escape($item['category']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?= ViewHelper::statusBadge($item['status']) ?>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                <?= ViewHelper::escape($item['author'] ?? 'Admin') ?>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="<?= BASE_URL ?>/index.php?page=items&action=edit&id=<?= $item['id'] ?>" 
                                       class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition">
                                        Edit
                                    </a>
                                    <form action="<?= BASE_URL ?>/index.php?page=items&action=delete" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');" class="inline">
                                        <?= CsrfHelper::getTokenInput() ?>
                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                        <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</div>
