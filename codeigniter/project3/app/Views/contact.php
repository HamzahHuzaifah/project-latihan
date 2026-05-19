<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-indigo-700 dark:bg-indigo-900 pb-24 pt-12" data-aos="fade-down">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-extrabold text-white sm:text-5xl md:text-6xl tracking-tight mb-4">Contact Us</h1>
        <p class="max-w-xl mt-5 mx-auto text-xl text-indigo-200">Hubungi kami melalui berbagai saluran yang tersedia di bawah ini.</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Card 1 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8 border border-slate-100 dark:border-slate-700 text-center" data-aos="fade-up" data-aos-delay="100">
            <div class="w-16 h-16 mx-auto bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center text-3xl mb-4">
                📍
            </div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Alamat</h2>
            <p class="text-slate-600 dark:text-slate-300">
                Jl. Teknologi No. 42<br>Jakarta Selatan, 12345<br>Indonesia
            </p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8 border border-slate-100 dark:border-slate-700 text-center" data-aos="fade-up" data-aos-delay="200">
            <div class="w-16 h-16 mx-auto bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 rounded-full flex items-center justify-center text-3xl mb-4">
                📧
            </div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Email</h2>
            <p class="text-slate-600 dark:text-slate-300">
                <a href="mailto:hello@myblog.com" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">hello@myblog.com</a><br>
                <a href="mailto:support@myblog.com" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">support@myblog.com</a>
            </p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8 border border-slate-100 dark:border-slate-700 text-center" data-aos="fade-up" data-aos-delay="300">
            <div class="w-16 h-16 mx-auto bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400 rounded-full flex items-center justify-center text-3xl mb-4">
                📞
            </div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2">No. HP</h2>
            <p class="text-slate-600 dark:text-slate-300">
                +62 812 3456 7890<br>
                +62 898 7654 3210
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>