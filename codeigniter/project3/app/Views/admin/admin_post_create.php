<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-indigo-700 dark:bg-indigo-900 pb-24 pt-12" data-aos="fade-down">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold text-white sm:text-5xl tracking-tight mb-2">Tulis Artikel Baru</h1>
        <p class="text-indigo-200 text-lg">Bagikan ide dan inspirasi terbaru Anda.</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 mb-20" data-aos="fade-up">
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 p-8">
        
        <form action="<?= base_url('admin/post/new') ?>" method="POST" id="postForm" enctype="multipart/form-data">
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Judul Artikel</label>
                    <input type="text" class="appearance-none block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm placeholder-slate-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm !bg-white dark:!bg-slate-700 !text-slate-900 dark:!text-white" id="title" name="title" placeholder="Masukkan judul yang menarik..." required>
                </div>

                <!-- Thumbnail -->
                <div>
                    <label for="thumbnail" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Thumbnail Artikel (Opsional)</label>
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="appearance-none block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm bg-white dark:bg-slate-700 text-slate-900 dark:text-white sm:text-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Status</label>
                        <select name="status" class="appearance-none block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm !bg-white dark:!bg-slate-700 !text-slate-900 dark:!text-white" id="status">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    
                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kategori</label>
                        <div class="flex items-center space-x-2 mt-2">
                            <select name="category_id" id="category_id" class="appearance-none block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm !bg-white dark:!bg-slate-700 !text-slate-900 dark:!text-white" onchange="toggleNewCategory()">
                                <?php foreach($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= esc($category['name']) ?></option>
                                <?php endforeach ?>
                                <option value="new" class="font-bold text-indigo-600">Lainnya (Tambah Baru)...</option>
                            </select>
                            <button type="button" onclick="editCategory()" class="p-2 text-blue-600 hover:bg-blue-100 rounded" title="Edit Kategori">✏️</button>
                            <button type="button" onclick="deleteCategory()" class="p-2 text-red-600 hover:bg-red-100 rounded" title="Hapus Kategori">🗑️</button>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Konten Artikel</label>
                    <input type="hidden" name="content" id="content">
                    <div id="editor-container" class="bg-white dark:bg-slate-900 text-slate-900 dark:text-white rounded-b-md" style="height: 400px;"></div>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <a href="<?= base_url('admin/post') ?>" class="inline-flex items-center px-4 py-2 border border-slate-300 dark:border-slate-600 shadow-sm text-sm font-medium rounded-md text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none transition-colors">Batal</a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">Simpan Artikel</button>
                </div>
            </div>
        </form>

    </div>
</div>

<?= $this->endSection() ?>