<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-indigo-700 dark:bg-indigo-900 pb-24 pt-12" data-aos="fade-down">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold text-white sm:text-5xl tracking-tight mb-2">Dashboard Admin</h1>
        <p class="text-indigo-200 text-lg">Selamat datang di panel kontrol MyBlog.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 mb-20">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Manajemen Artikel -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 p-8 text-center" data-aos="fade-up" data-aos-delay="100">
            <div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center text-3xl mb-4">
                📝
            </div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Manajemen Artikel</h2>
            <p class="text-slate-600 dark:text-slate-400 mb-6">Tulis, edit, dan kelola semua artikel blog Anda dengan mudah.</p>
            <a href="<?= base_url('admin/post') ?>" class="inline-flex w-full items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                Kelola Artikel
            </a>
        </div>

        <!-- Tulis Artikel Baru -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 p-8 text-center" data-aos="fade-up" data-aos-delay="200">
            <div class="w-16 h-16 mx-auto bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 rounded-full flex items-center justify-center text-3xl mb-4">
                ➕
            </div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Tulis Artikel Baru</h2>
            <p class="text-slate-600 dark:text-slate-400 mb-6">Bagikan ide dan inspirasi terbaru Anda kepada pembaca.</p>
            <a href="<?= base_url('admin/post/new') ?>" class="inline-flex w-full items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 transition-colors">
                Tulis Sekarang
            </a>
        </div>

        <!-- Pengaturan -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 p-8 text-center" data-aos="fade-up" data-aos-delay="300">
            <div class="w-16 h-16 mx-auto bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 rounded-full flex items-center justify-center text-3xl mb-4">
                ⚙️
            </div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Pengaturan Situs</h2>
            <p class="text-slate-600 dark:text-slate-400 mb-6">Sesuaikan profil Anda dan pengaturan dasar website ini.</p>
            <a href="<?= base_url('admin/setting') ?>" class="inline-flex w-full items-center justify-center px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                Buka Pengaturan
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
