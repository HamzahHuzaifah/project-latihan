<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-indigo-700 dark:bg-indigo-900 pb-24 pt-12" data-aos="fade-down">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-extrabold text-white sm:text-5xl md:text-6xl tracking-tight mb-4">FAQ</h1>
        <p class="max-w-xl mt-5 mx-auto text-xl text-indigo-200">Pertanyaan yang Sering Diajukan.</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16">
    <div class="space-y-6">
        <!-- FAQ 1 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8 border border-slate-100 dark:border-slate-700" data-aos="fade-up" data-aos-delay="100">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 flex items-start">
                <span class="text-indigo-600 dark:text-indigo-400 mr-3">Q:</span>
                Bagaimana cara membuat postingan baru?
            </h3>
            <div class="text-slate-600 dark:text-slate-300 flex items-start">
                <span class="font-bold text-slate-400 dark:text-slate-500 mr-3">A:</span>
                <p class="mb-0">Anda harus login sebagai Admin terlebih dahulu. Setelah login, tombol "New Post" akan muncul di menu navigasi atau Anda dapat mengaksesnya melalui dashboard admin.</p>
            </div>
        </div>

        <!-- FAQ 2 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8 border border-slate-100 dark:border-slate-700" data-aos="fade-up" data-aos-delay="200">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 flex items-start">
                <span class="text-indigo-600 dark:text-indigo-400 mr-3">Q:</span>
                Apakah saya bisa berkomentar tanpa memiliki akun?
            </h3>
            <div class="text-slate-600 dark:text-slate-300 flex items-start">
                <span class="font-bold text-slate-400 dark:text-slate-500 mr-3">A:</span>
                <p class="mb-0">Ya, Anda dapat berkomentar dengan hanya memasukkan nama dan isi komentar Anda di halaman detail artikel. Tidak perlu membuat akun untuk berinteraksi!</p>
            </div>
        </div>

        <!-- FAQ 3 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8 border border-slate-100 dark:border-slate-700" data-aos="fade-up" data-aos-delay="300">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 flex items-start">
                <span class="text-indigo-600 dark:text-indigo-400 mr-3">Q:</span>
                Bagaimana cara mengaktifkan Mode Gelap (Dark Mode)?
            </h3>
            <div class="text-slate-600 dark:text-slate-300 flex items-start">
                <span class="font-bold text-slate-400 dark:text-slate-500 mr-3">A:</span>
                <p class="mb-0">Cukup klik tombol ikon bulan (🌙) di bagian kanan atas layar Anda (pada menu navigasi). Preferensi Anda akan disimpan sehingga Anda tidak perlu mengaturnya lagi di kunjungan berikutnya.</p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>