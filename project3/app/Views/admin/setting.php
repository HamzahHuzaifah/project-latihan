<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-indigo-700 dark:bg-indigo-900 pb-24 pt-12" data-aos="fade-down">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold text-white sm:text-5xl tracking-tight mb-2">Pengaturan</h1>
        <p class="text-indigo-200 text-lg">Sesuaikan pengaturan akun dan preferensi Anda.</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 mb-20" data-aos="fade-up">
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 p-8">
        
        <?php if (session()->getFlashdata('message')) : ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/setting') ?>" method="post" class="space-y-8">
            <?= csrf_field() ?>
            <div class="border-b border-slate-200 dark:border-slate-700 pb-6">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Profil Akun</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Ubah informasi dasar akun admin Anda.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Username</label>
                        <input type="text" name="username" value="<?= old('username', user()->username ?? '') ?>" class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm sm:text-sm !bg-white dark:!bg-slate-700 !text-slate-900 dark:!text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email Address</label>
                        <input type="email" name="email" value="<?= old('email', user()->email ?? '') ?>" class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm sm:text-sm !bg-white dark:!bg-slate-700 !text-slate-900 dark:!text-white">
                    </div>
                </div>
            </div>

            <div class="border-b border-slate-200 dark:border-slate-700 pb-6">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Ganti Password</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Biarkan kosong jika tidak ingin mengubah password.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password Baru</label>
                        <input type="password" name="password" class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm sm:text-sm !bg-white dark:!bg-slate-700 !text-slate-900 dark:!text-white" placeholder="Minimal 8 karakter">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Konfirmasi Password</label>
                        <input type="password" name="pass_confirm" class="mt-1 block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm sm:text-sm !bg-white dark:!bg-slate-700 !text-slate-900 dark:!text-white" placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>


            <div class="pt-2 flex justify-between items-center">
                <a href="<?= base_url('admin') ?>" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium">
                    &larr; Kembali ke Dashboard
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>

<?= $this->endSection() ?>
