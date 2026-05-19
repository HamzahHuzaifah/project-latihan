<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="bg-indigo-700 dark:bg-indigo-900 pb-24 pt-12" data-aos="fade-down">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-extrabold text-white sm:text-5xl md:text-6xl tracking-tight mb-4">About Me</h1>
        <p class="max-w-xl mt-5 mx-auto text-xl text-indigo-200">Kenali siapa saya, apa yang saya lakukan, dan bagaimana saya melakukannya.</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16">
    <div class="space-y-8">
        <!-- Card 1 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8 border border-slate-100 dark:border-slate-700" data-aos="fade-up" data-aos-delay="100">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                <span class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 p-2 rounded-lg mr-4 text-xl">👤</span>
                Siapa Aku
            </h2>
            <p class="text-slate-600 dark:text-slate-300 text-lg leading-relaxed">
                Saya adalah seorang pengembang web yang bersemangat tentang teknologi dan inovasi. Saya suka membangun aplikasi yang memecahkan masalah nyata dan memberikan pengalaman pengguna yang luar biasa.
            </p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8 border border-slate-100 dark:border-slate-700" data-aos="fade-up" data-aos-delay="200">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                <span class="bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 p-2 rounded-lg mr-4 text-xl">💻</span>
                Bisa Apa Aku
            </h2>
            <p class="text-slate-600 dark:text-slate-300 text-lg leading-relaxed">
                Keahlian saya meliputi pengembangan frontend modern dengan alat seperti Tailwind CSS dan React, serta pengembangan backend yang solid menggunakan kerangka kerja seperti CodeIgniter dan Laravel.
            </p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8 border border-slate-100 dark:border-slate-700" data-aos="fade-up" data-aos-delay="300">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                <span class="bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400 p-2 rounded-lg mr-4 text-xl">🚀</span>
                Bagaimana Aku
            </h2>
            <p class="text-slate-600 dark:text-slate-300 text-lg leading-relaxed">
                Saya percaya pada pembelajaran berkelanjutan dan kolaborasi. Proses kerja saya sangat iteratif, dengan fokus pada penulisan kode yang bersih, mudah dipelihara, dan dapat diukur.
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>