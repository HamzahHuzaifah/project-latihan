<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php if (!isset($is_blog_page) || !$is_blog_page): ?>
<!-- Hero Section -->
<div class="relative bg-white dark:bg-slate-900 overflow-hidden" data-aos="fade-down">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white dark:bg-slate-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-20 px-4 sm:px-6 lg:px-8">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 dark:text-white sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Jelajahi Artikel</span>
                        <span class="block text-indigo-600 dark:text-indigo-400">Penuh Inovasi</span>
                    </h1>
                    <p class="mt-3 text-base text-slate-500 dark:text-slate-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Temukan berbagai ide, tutorial, dan cerita inspiratif di MyBlog. Kami menghadirkan bacaan segar setiap hari.
                    </p>
                    
                    <!-- Category Filters -->
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start flex-wrap gap-2">
                        <a href="<?= base_url() ?>" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm <?= empty($current_category) ? 'text-white bg-indigo-600 hover:bg-indigo-700' : 'text-indigo-700 bg-indigo-100 hover:bg-indigo-200 dark:text-indigo-200 dark:bg-indigo-900 dark:hover:bg-indigo-800' ?> no-underline">
                            Semua
                        </a>
                        <?php foreach($categories as $cat): ?>
                            <a href="<?= base_url('?category=' . $cat['slug']) ?>" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm <?= $current_category == $cat['slug'] ? 'text-white bg-indigo-600 hover:bg-indigo-700' : 'text-indigo-700 bg-indigo-100 hover:bg-indigo-200 dark:text-indigo-200 dark:bg-indigo-900 dark:hover:bg-indigo-800' ?> no-underline">
                                <?= $cat['name'] ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
<?php else: ?>
<!-- Minimal Header for Blog Page -->
<div class="bg-indigo-700 dark:bg-indigo-900 pb-24 pt-12" data-aos="fade-down">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-extrabold text-white sm:text-5xl md:text-6xl tracking-tight mb-4">Blog</h1>
        <p class="max-w-xl mt-5 mx-auto text-xl text-indigo-200">Kumpulan Artikel Kami.</p>
        
        <!-- Category Filters -->
        <div class="mt-8 flex justify-center flex-wrap gap-2">
            <a href="<?= base_url('post') ?>" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm <?= empty($current_category) ? 'text-indigo-700 bg-white' : 'text-white bg-indigo-600 hover:bg-indigo-500 dark:bg-indigo-800 dark:hover:bg-indigo-700 border-indigo-400' ?> no-underline">
                Semua
            </a>
            <?php foreach($categories as $cat): ?>
                <a href="<?= base_url('post?category=' . $cat['slug']) ?>" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm <?= $current_category == $cat['slug'] ? 'text-indigo-700 bg-white' : 'text-white bg-indigo-600 hover:bg-indigo-500 dark:bg-indigo-800 dark:hover:bg-indigo-700 border-indigo-400' ?> no-underline">
                    <?= $cat['name'] ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="-mt-16"></div>
<?php endif; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Search Bar -->
    <div class="mb-10 max-w-2xl mx-auto" data-aos="fade-up">
        <form action="<?= base_url('search') ?>" method="GET" class="relative" data-no-swup>
            <div class="flex items-center bg-white dark:bg-slate-800 rounded-full shadow-md border border-slate-200 dark:border-slate-700 overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
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

    <?php if(!empty($keyword)): ?>
        <p class="text-lg text-slate-600 dark:text-slate-300 mb-8" data-aos="fade-in">Menampilkan hasil pencarian untuk: <strong class="text-indigo-600 dark:text-indigo-400">"<?= esc($keyword) ?>"</strong></p>
    <?php endif; ?>

    <?php if(empty($posts)): ?>
        <div class="text-center py-20" data-aos="zoom-in">
            <h5 class="text-2xl text-slate-500 dark:text-slate-400">Tidak ada artikel ditemukan.</h5>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php $delay = 100; foreach($posts as $post): 
                $word_count = str_word_count(strip_tags($post['content']));
                $reading_time = ceil($word_count / 200);
                if ($reading_time < 1) $reading_time = 1;
            ?>
            <!-- Post Card -->
            <div class="flex flex-col rounded-2xl shadow-lg overflow-hidden bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                <div class="flex-shrink-0 relative">
                    <?php $thumbnailUrl = !empty($post['thumbnail']) ? base_url('uploads/thumbnails/' . $post['thumbnail']) : 'https://images.unsplash.com/photo-1599507593499-a3f7d1d08731?q=80&w=800&auto=format&fit=crop'; ?>
                    <img class="h-48 w-full object-cover" src="<?= $thumbnailUrl ?>" alt="<?= esc($post['title']) ?>">
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-white/90 text-indigo-800 backdrop-blur-sm shadow">
                            <?= $post['category_name'] ?? 'Umum' ?>
                        </span>
                    </div>
                </div>
                <div class="flex-1 bg-white dark:bg-slate-800 p-6 flex flex-col justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400 mb-1">
                            ⏱️ <?= $reading_time ?> min read
                        </p>
                        <a href="<?= base_url('post/' . $post['slug']) ?>" class="block mt-2 no-underline group">
                            <h3 class="text-xl font-semibold text-slate-900 dark:text-white group-hover:text-indigo-600 transition-colors">
                                <?= esc($post['title']) ?>
                            </h3>
                            <p class="mt-3 text-base text-slate-500 dark:text-slate-400 line-clamp-3">
                                <?= character_limiter(strip_tags($post['content']), 100) ?>
                            </p>
                        </a>
                    </div>
                    <div class="mt-6 flex items-center justify-between border-t border-slate-100 dark:border-slate-700 pt-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold">
                                <?= strtoupper(substr($post['author'], 0, 1)) ?>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-slate-900 dark:text-white mb-0">
                                    <?= esc($post['author']) ?>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                            👏 <?= $post['likes'] ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php $delay += 100; endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>