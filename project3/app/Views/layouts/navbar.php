<?php helper('auth'); ?>
<nav class="sticky top-0 z-50 glass shadow-sm">
  <div class="container mx-auto px-4">
    <div class="flex items-center justify-between h-16">
      <div class="flex items-center">
        <a class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 no-underline" href="<?= base_url() ?>">MyBlog</a>
        <div class="hidden md:block ml-10">
          <div class="flex items-baseline space-x-4">
            <a href="<?= base_url() ?>" class="<?= url_is('/') || url_is('') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-slate-600 hover:text-indigo-600 dark:text-slate-300 dark:hover:text-white' ?> px-3 py-2 rounded-md text-sm font-medium transition-colors no-underline">Home</a>
            <a href="<?= base_url('about') ?>" class="<?= url_is('about') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-slate-600 hover:text-indigo-600 dark:text-slate-300 dark:hover:text-white' ?> px-3 py-2 rounded-md text-sm font-medium transition-colors no-underline">About</a>
            <a href="<?= base_url('post') ?>" class="<?= url_is('post*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-slate-600 hover:text-indigo-600 dark:text-slate-300 dark:hover:text-white' ?> px-3 py-2 rounded-md text-sm font-medium transition-colors no-underline">Blog</a>
            <a href="<?= base_url('contact') ?>" class="<?= url_is('contact') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-slate-600 hover:text-indigo-600 dark:text-slate-300 dark:hover:text-white' ?> px-3 py-2 rounded-md text-sm font-medium transition-colors no-underline">Contact</a>
            <a href="<?= base_url('faqs') ?>" class="<?= url_is('faqs') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200' : 'text-slate-600 hover:text-indigo-600 dark:text-slate-300 dark:hover:text-white' ?> px-3 py-2 rounded-md text-sm font-medium transition-colors no-underline">FAQ</a>
          </div>
        </div>
      </div>
      
      <div class="flex items-center space-x-4">
        <!-- Dark Mode Toggle Removed (Available in Settings) -->

        <!-- Auth Buttons -->
        <?php if (logged_in()) : ?>
            <div class="hidden md:flex items-center space-x-3">
                <a href="<?= base_url('admin') ?>" class="inline-flex px-4 py-2 bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200 rounded-md hover:bg-indigo-200 dark:hover:bg-indigo-800 transition-colors text-sm font-medium no-underline">Dashboard</a>
                <a href="<?= base_url('logout') ?>" data-no-swup class="inline-flex px-4 py-2 border border-red-500 text-red-500 rounded-md hover:bg-red-500 hover:text-white transition-colors text-sm font-medium no-underline">Logout</a>
            </div>
        <?php else: ?>
            <a href="<?= base_url('login') ?>" data-no-swup class="hidden md:inline-flex px-4 py-2 border border-indigo-600 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors text-sm font-medium no-underline">Login</a>
        <?php endif; ?>
        
        <!-- Mobile menu button -->
        <div class="md:hidden flex items-center">
          <button type="button" class="text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white" data-bs-toggle="collapse" data-bs-target="#mobileMenu">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div class="collapse md:hidden" id="mobileMenu">
    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white dark:bg-slate-800 shadow-lg">
      <a href="<?= base_url() ?>" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-700 no-underline">Home</a>
      <a href="<?= base_url('about') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-700 no-underline">About</a>
      <a href="<?= base_url('post') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-700 no-underline">Blog</a>
      <a href="<?= base_url('contact') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-700 no-underline">Contact</a>
      <a href="<?= base_url('faqs') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 dark:text-white hover:bg-slate-100 dark:hover:bg-slate-700 no-underline">FAQ</a>
      
      <div class="border-t border-slate-200 dark:border-slate-700 my-2"></div>
      
      <?php if (logged_in()) : ?>
          <a href="<?= base_url('admin') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-indigo-600 dark:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-700 no-underline">Admin Dashboard</a>
          <a href="<?= base_url('logout') ?>" data-no-swup class="block px-3 py-2 rounded-md text-base font-medium text-red-500 hover:bg-slate-100 dark:hover:bg-slate-700 no-underline">Logout</a>
      <?php else: ?>
          <a href="<?= base_url('login') ?>" data-no-swup class="block px-3 py-2 rounded-md text-base font-medium text-indigo-600 dark:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-700 no-underline">Login</a>
      <?php endif; ?>

    </div>
  </div>
</nav>