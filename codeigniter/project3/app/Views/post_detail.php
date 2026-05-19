
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12" data-aos="fade-up">
    <!-- Header -->
    <div class="text-center mb-12">
        <div class="mb-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                <?= $post['category_name'] ?? 'Umum' ?>
            </span>
        </div>
        <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white mb-6">
            <?= esc($post['title']) ?>
        </h1>
        <div class="flex items-center justify-center text-slate-500 dark:text-slate-400 space-x-4">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold text-lg">
                    <?= strtoupper(substr($post['author'], 0, 1)) ?>
                </div>
                <div class="ml-3 text-left">
                    <p class="text-sm font-medium text-slate-900 dark:text-white mb-0">
                        <?= esc($post['author']) ?>
                    </p>
                    <p class="text-sm mb-0">
                        <?= date('d M Y', strtotime($post['created_at'])) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Thumbnail -->
    <?php if (!empty($post['thumbnail'])): ?>
        <div class="mb-10 rounded-2xl overflow-hidden shadow-lg" data-aos="fade-up" data-aos-delay="50">
            <img src="<?= base_url('uploads/thumbnails/' . $post['thumbnail']) ?>" alt="<?= esc($post['title']) ?>" class="w-full h-auto object-cover max-h-[500px]">
        </div>
    <?php endif; ?>

    <!-- Content -->
    <div class="post-content mx-auto mb-16 text-lg text-slate-800 dark:text-slate-200 leading-relaxed" data-aos="fade-up" data-aos-delay="100">
        <?= $post['content'] ?>
    </div>

    <!-- Actions (Like & Share) -->
    <div class="flex justify-between items-center py-6 border-t border-b border-slate-200 dark:border-slate-700 mb-16" data-aos="fade-up" data-aos-delay="200">
        <div>
            <button id="likeBtn" data-id="<?= $post['id'] ?>" class="inline-flex items-center px-4 py-2 border border-slate-300 dark:border-slate-600 shadow-sm text-sm font-medium rounded-full text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none transition-colors">
                <span class="mr-2 text-xl">👏</span> 
                <span id="likeCount" class="font-bold"><?= $post['likes'] ?></span>
            </button>
        </div>
        <div>
            <a href="https://api.whatsapp.com/send?text=<?= urlencode(base_url('post/'.$post['slug'])) ?>" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none transition-colors no-underline">
                Share WhatsApp
            </a>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="mt-12" data-aos="fade-up" data-aos-delay="300">
        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-8">Komentar (<span id="commentCount"><?= count($comments ?? []) ?></span>)</h3>
        
        <?php if (session()->getFlashdata('message')) : ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

        <!-- Comment Form -->
        <form action="<?= base_url('post/comment/'.$post['id']) ?>" method="post" class="mb-12 bg-slate-50 dark:bg-slate-800/50 p-6 rounded-xl border border-slate-200 dark:border-slate-700">
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama Anda</label>
                <input type="text" name="name" class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Komentar</label>
                <textarea name="comment" rows="3" class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none" required></textarea>
            </div>
            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition-colors">
                Kirim Komentar
            </button>
        </form>

        <!-- Comments List -->
        <div class="space-y-8">
            <?php if(empty($comments)): ?>
                <p class="text-slate-500 dark:text-slate-400 italic text-center py-8">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
            <?php else: ?>
                <?php foreach($comments as $comment): ?>
                <div class="flex space-x-4 bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 rounded-full bg-slate-200 dark:bg-slate-600 flex items-center justify-center text-slate-600 dark:text-slate-300 font-bold text-lg">
                            <?= strtoupper(substr($comment['name'], 0, 1)) ?>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="text-lg font-bold text-slate-900 dark:text-white"><?= esc($comment['name']) ?></h4>
                            <span class="text-sm text-slate-500 dark:text-slate-400"><?= date('d M Y H:i', strtotime($comment['created_at'])) ?></span>
                        </div>
                        <p class="text-slate-700 dark:text-slate-300 mt-2 whitespace-pre-line"><?= esc($comment['comment']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>