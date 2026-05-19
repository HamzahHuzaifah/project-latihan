<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="bg-indigo-700 dark:bg-indigo-900 pb-24 pt-12" data-aos="fade-down">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl font-extrabold text-white sm:text-4xl md:text-5xl tracking-tight mb-4">
            Hasil Pencarian: <span class="text-indigo-200">"<?= esc($keyword) ?>"</span>
        </h1>
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 border border-white/20 text-white text-sm">
            ✨ Powered by Google Gemini AI
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 pb-20" data-aos="fade-up">
    
    <!-- Search Bar -->
    <div class="mb-10 max-w-2xl mx-auto bg-white/10 p-2 rounded-full backdrop-blur-md">
        <form action="<?= base_url('search') ?>" method="GET" class="relative" data-no-swup>
            <div class="flex items-center bg-white dark:bg-slate-800 rounded-full shadow-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all border-2 border-indigo-200 dark:border-indigo-800">
                <div class="pl-5 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="keyword" value="<?= isset($keyword) ? esc($keyword) : '' ?>" placeholder="Tanya AI atau cari artikel..." class="w-full py-4 px-4 bg-transparent border-none text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-0">
                <button type="submit" class="pr-2 pl-2 h-full flex items-center justify-center">
                    <span class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-full px-6 py-2 text-sm font-medium transition-colors shadow-sm">Cari</span>
                </button>
            </div>
        </form>
    </div>


    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-8 shadow-sm">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($results)) : ?>
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 p-12 text-center">
            <div class="text-6xl mb-4">🔍</div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Tidak ada hasil ditemukan</h3>
            <p class="text-slate-500 dark:text-slate-400">AI kami tidak menemukan artikel yang relevan dengan pencarian "<?= esc($keyword) ?>". Silakan coba kata kunci lain.</p>
        </div>
    <?php else : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($results as $post): ?>
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 rounded-2xl border border-slate-100 dark:border-slate-700 flex flex-col h-full transform hover:-translate-y-1">
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex items-center text-sm text-slate-500 dark:text-slate-400 mb-4 space-x-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                <?= esc($post['category_name'] ?? 'Umum') ?>
                            </span>
                            <span class="flex items-center">
                                <?= date('d M Y', strtotime($post['created_at'])) ?>
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 leading-tight line-clamp-2">
                            <a href="<?= base_url('post/' . $post['slug']) ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors no-underline">
                                <?= esc($post['title']) ?>
                            </a>
                        </h3>
                        
                        <div class="text-slate-600 dark:text-slate-300 text-sm mb-6 flex-grow line-clamp-3">
                            <?= strip_tags($post['content']) ?>
                        </div>
                        
                        <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold text-xs">
                                    <?= strtoupper(substr($post['author'] ?? 'A', 0, 1)) ?>
                                </div>
                                <span class="ml-2 text-sm font-medium text-slate-700 dark:text-slate-300">
                                    <?= esc($post['author'] ?? 'Admin') ?>
                                </span>
                            </div>
                            <a href="<?= base_url('post/' . $post['slug']) ?>" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 no-underline">
                                Baca <span class="ml-1">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
