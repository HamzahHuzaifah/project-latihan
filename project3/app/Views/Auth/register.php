<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="min-h-[70vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-slate-50 dark:bg-slate-900" data-aos="fade-in">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center mb-6">
            <span class="inline-block bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 p-3 rounded-full text-3xl">
                📝
            </span>
        </div>
        <h2 class="mt-2 text-center text-3xl font-extrabold text-slate-900 dark:text-white">
            <?=lang('Auth.register')?>
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600 dark:text-slate-400">
            Sudah punya akun? <a href="<?= url_to('login') ?>" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300"><?=lang('Auth.alreadyRegistered')?> <?=lang('Auth.signIn')?></a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white dark:bg-slate-800 py-8 px-4 shadow sm:rounded-xl sm:px-10 border border-slate-100 dark:border-slate-700">
            <?= view('Myth\Auth\Views\_message_block') ?>

            <form action="<?= url_to('register') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300"><?=lang('Auth.email')?></label>
                    <div class="mt-1">
                        <input type="email" name="email" class="appearance-none block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm placeholder-slate-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm !bg-white dark:!bg-slate-700 !text-slate-900 dark:!text-white <?php if (session('errors.email')) : ?>border-red-500<?php endif ?>" placeholder="<?=lang('Auth.email')?>" value="<?= old('email') ?>">
                    </div>
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-slate-700 dark:text-slate-300"><?=lang('Auth.username')?></label>
                    <div class="mt-1">
                        <input type="text" name="username" class="appearance-none block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm placeholder-slate-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm !bg-white dark:!bg-slate-700 !text-slate-900 dark:!text-white <?php if (session('errors.username')) : ?>border-red-500<?php endif ?>" placeholder="<?=lang('Auth.username')?>" value="<?= old('username') ?>">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300"><?=lang('Auth.password')?></label>
                    <div class="mt-1">
                        <input type="password" name="password" class="appearance-none block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm placeholder-slate-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm !bg-white dark:!bg-slate-700 !text-slate-900 dark:!text-white <?php if (session('errors.password')) : ?>border-red-500<?php endif ?>" placeholder="<?=lang('Auth.password')?>" autocomplete="off">
                    </div>
                </div>

                <div>
                    <label for="pass_confirm" class="block text-sm font-medium text-slate-700 dark:text-slate-300"><?=lang('Auth.repeatPassword')?></label>
                    <div class="mt-1">
                        <input type="password" name="pass_confirm" class="appearance-none block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-md shadow-sm placeholder-slate-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm !bg-white dark:!bg-slate-700 !text-slate-900 dark:!text-white <?php if (session('errors.pass_confirm')) : ?>border-red-500<?php endif ?>" placeholder="<?=lang('Auth.repeatPassword')?>" autocomplete="off">
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <?=lang('Auth.register')?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
