<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-indigo-700 dark:bg-indigo-900 pb-24 pt-12" data-aos="fade-down">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-extrabold text-white sm:text-5xl tracking-tight mb-2">Admin Dashboard</h1>
            <p class="text-indigo-200 text-lg">Kelola semua artikel Anda dari sini.</p>
        </div>
        <div>
            <a href="<?= base_url('admin/post/new') ?>" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-indigo-700 bg-white hover:bg-indigo-50 focus:outline-none transition-colors">
                + Tulis Artikel Baru
            </a>
            <a href="<?= base_url('admin/setting') ?>" class="ml-3 inline-flex items-center px-4 py-3 border border-indigo-300 text-base font-medium rounded-lg shadow-sm text-white hover:bg-indigo-800 focus:outline-none transition-colors">
                ⚙️ Pengaturan
            </a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 mb-20">
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 overflow-hidden" data-aos="fade-up">
        
        <?php if (session()->getFlashdata('message')) : ?>
            <div class="m-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <strong>Berhasil!</strong> <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">#</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Judul & Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                    <?php $no = 0; foreach($posts as $post): $no++; ?>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400">
                            <?= $no; ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-slate-900 dark:text-white"><?= esc($post['title']) ?></div>
                            <div class="text-sm text-slate-500 dark:text-slate-400"><?= date('d M Y', strtotime($post['created_at'])) ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($post['status'] === 'published'): ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Published
                                </span>
                            <?php else: ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300">
                                    Draft
                                </span>
                            <?php endif ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="<?= base_url('admin/post/'.$post['id'].'/preview') ?>" target="_blank" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">Preview</a>
                            <a href="<?= base_url('admin/post/'.$post['id'].'/edit') ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">Edit</a>
                            <button data-href="<?= base_url('admin/post/'.$post['id'].'/delete') ?>" onclick="confirmToDelete(this)" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 focus:outline-none">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal (Tailwind CSS Modal) -->
<div id="confirm-dialog" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-slate-900/75 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="closeModal()"></div>

        <!-- Modal panel -->
        <div class="relative inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-slate-800 shadow-xl rounded-2xl">
            <div class="flex flex-col items-center justify-center">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full dark:bg-red-900/30 mb-4">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold leading-6 text-slate-900 dark:text-white" id="modal-title">Hapus Artikel?</h3>
                <div class="mt-2 text-center">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Apakah Anda yakin ingin menghapus artikel ini? Data akan dihapus secara permanen dan tidak dapat dikembalikan.</p>
                </div>
            </div>
            
            <div class="mt-8 flex flex-col sm:flex-row gap-3 sm:justify-center">
                <button type="button" onclick="closeModal()" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-slate-300 dark:border-slate-600 px-6 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition-all">
                    Batal
                </button>
                <a href="#" id="delete-button" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-transparent px-6 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all">
                    Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>