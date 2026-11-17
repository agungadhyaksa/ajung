<div class="max-w-2xl mx-auto">

    <div class="mb-5 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Edit Data Item</h2>
            <p class="text-slate-500 text-sm">Perbarui informasi untuk item #<?= $item['id'] ?>.</p>
        </div>
        <a href="<?= BASE_URL ?>/index.php?page=items" class="text-sm font-medium text-slate-600 hover:text-slate-900">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <form action="<?= BASE_URL ?>/index.php?page=items&action=update" method="POST" class="space-y-5">
            <?= CsrfHelper::getTokenInput() ?>
            <input type="hidden" name="id" value="<?= $item['id'] ?>">

            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-1">
                    Judul Item <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="title" name="title" required
                       value="<?= ViewHelper::escape($item['title']) ?>"
                       class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm text-slate-800">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-sm font-medium text-slate-700 mb-1">
                        Kategori <span class="text-rose-500">*</span>
                    </label>
                    <select id="category" name="category" required
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm text-slate-800 bg-white">
                        <?php
                        $categories = ['Dokumentasi', 'Infrastruktur', 'Desain', 'Pengembangan', 'Umum'];
                        foreach ($categories as $cat):
                        ?>
                            <option value="<?= $cat ?>" <?= $item['category'] === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-1">
                        Status <span class="text-rose-500">*</span>
                    </label>
                    <select id="status" name="status" required
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm text-slate-800 bg-white">
                        <option value="active" <?= $item['status'] === 'active' ? 'selected' : '' ?>>Aktif (Active)</option>
                        <option value="pending" <?= $item['status'] === 'pending' ? 'selected' : '' ?>>Menunggu (Pending)</option>
                        <option value="completed" <?= $item['status'] === 'completed' ? 'selected' : '' ?>>Selesai (Completed)</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1">
                    Deskripsi Detail
                </label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none text-sm text-slate-800"><?= ViewHelper::escape($item['description']) ?></textarea>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="<?= BASE_URL ?>/index.php?page=items" 
                   class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 rounded-lg hover:bg-slate-100 transition">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-lg shadow text-sm transition">
                    Perbarui Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
