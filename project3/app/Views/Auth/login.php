<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="min-h-[70vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-slate-50 dark:bg-slate-900" data-aos="fade-in">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center mb-6">
            <span class="inline-block bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 p-3 rounded-full text-3xl">
                🔒
            </span>
        </div>
        <h2 class="mt-2 text-center text-3xl font-extrabold text-slate-900 dark:text-white">
            <?=lang('Auth.loginTitle')?>
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600 dark:text-slate-400">
            Belum punya akun? <a href="<?= url_to('register') ?>" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Daftar sekarang</a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white dark:bg-slate-800 py-8 px-4 shadow sm:rounded-xl sm:px-10 border border-slate-100 dark:border-slate-700">
            <?= view('Myth\Auth\Views\_message_block') ?>

            <form action="<?= url_to('login') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>

                <?php if ($config->validFields === ['email']): ?>
                    <div>
                        <label for="login" class="block text-sm font-medium text-slate-700 dark:text-slate-300"><?=lang('Auth.email')?></label>
                        <div class="mt-1">
                            <input type="email" name="login" class="appearance-none block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm placeholder-slate-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm !bg-white dark:!bg-slate-700 !text-slate-900 dark:!text-white <?php if (session('errors.login')) : ?>border-red-500<?php endif ?>" placeholder="<?=lang('Auth.email')?>">
                            <div class="invalid-feedback text-red-500 text-xs mt-1">
                                <?= session('errors.login') ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div>
                        <label for="login" class="block text-sm font-medium text-slate-700 dark:text-slate-300"><?=lang('Auth.emailOrUsername')?></label>
                        <div class="mt-1">
                            <input type="text" name="login" class="appearance-none block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm placeholder-slate-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm !bg-white dark:!bg-slate-700 !text-slate-900 dark:!text-white <?php if (session('errors.login')) : ?>border-red-500<?php endif ?>" placeholder="<?=lang('Auth.emailOrUsername')?>">
                            <div class="invalid-feedback text-red-500 text-xs mt-1">
                                <?= session('errors.login') ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300"><?=lang('Auth.password')?></label>
                    <div class="mt-1">
                        <input type="password" name="password" class="appearance-none block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm placeholder-slate-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm !bg-white dark:!bg-slate-700 !text-slate-900 dark:!text-white <?php if (session('errors.password')) : ?>border-red-500<?php endif ?>" placeholder="<?=lang('Auth.password')?>">
                        <div class="invalid-feedback text-red-500 text-xs mt-1">
                            <?= session('errors.password') ?>
                        </div>
                    </div>
                </div>

                <?php if ($config->allowRemembering): ?>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded" <?php if (old('remember')) : ?> checked <?php endif ?>>
                            <label for="remember" class="ml-2 block text-sm text-slate-900 dark:text-slate-300">
                                <?=lang('Auth.rememberMe')?>
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="<?= url_to('forgot') ?>" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                <?=lang('Auth.forgotYourPassword')?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <?=lang('Auth.loginAction')?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
