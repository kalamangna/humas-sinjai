<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Auth routes
$routes->get('login', 'Auth\Login::index');
$routes->post('login', 'Auth\Login::attemptLogin');
$routes->get('logout', 'Auth\Login::logout');



$routes->get('posts', 'Home::posts');
$routes->get('post/(:segment)', 'Home::post/$1');
$routes->get('category/(:segment)', 'Home::category/$1');
$routes->get('tag/(:segment)', 'Home::tag/$1');
$routes->get('tags', 'Home::tags');
$routes->get('about', 'Page::about');
$routes->get('contact', 'Page::contact');
$routes->get('search', 'Home::search');

$routes->get('categories', 'Home::categories');

$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->resource('posts', ['controller' => 'Admin\Posts']);
    $routes->resource('categories', ['controller' => 'Admin\Categories']);
    $routes->resource('tags', ['controller' => 'Admin\Tags']);
    $routes->resource('users', ['controller' => 'Admin\Users', 'placeholder' => '(:num)', 'filter' => 'admin']);
    $routes->get('profile', 'Admin\Users::profile');
    $routes->get('settings', 'Admin\Users::settings');
    $routes->post('users/update_settings', 'Admin\Users::update_settings');
});
