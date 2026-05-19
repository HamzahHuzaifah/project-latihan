<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');

$routes->get('/post', 'Post::index');
$routes->get('/post/(:any)', 'Post::viewPost/$1');
$routes->post('/post/comment/(:num)', 'Post::addComment/$1');
$routes->post('/post/like/(:num)', 'Post::likePost/$1');
$routes->post('/post/chat/(:num)', 'Post::chat/$1');

$routes->match(['get', 'post'], '/search', 'Search::index');
$routes->post('/global-chat', 'Home::globalChat');

$routes->group('admin', ['filter' => 'login'], function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('setting', 'Admin::setting');
    $routes->post('setting', 'Admin::settingUpdate');
    $routes->get('post', 'PostAdmin::index');
    $routes->get('post/(:segment)/preview', 'PostAdmin::preview/$1');
    $routes->add('post/new', 'PostAdmin::create');
    $routes->add('post/(:segment)/edit', 'PostAdmin::edit/$1');
    $routes->get('post/(:segment)/delete', 'PostAdmin::delete/$1');
    $routes->post('post/upload-image', 'PostAdmin::uploadImage');
    $routes->get('category', 'PostAdmin::getCategories');
    $routes->post('category/store', 'PostAdmin::storeCategory');
    $routes->post('category/(:segment)/update', 'PostAdmin::updateCategory/$1');
    $routes->post('category/(:segment)/delete', 'PostAdmin::deleteCategory/$1');
});