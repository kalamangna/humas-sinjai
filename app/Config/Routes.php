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
$routes->get('rss', 'Home::rss');
$routes->get('sitemap.xml', 'Home::sitemap');

$routes->post('api/tags/suggest', 'Api\TagSuggestion::suggest');

$routes->get('api/analytics/overview', 'Admin\\Analytics::overview');
$routes->get('api/analytics/top-pages', 'Admin\\Analytics::getTopPages');
$routes->get('api/analytics/traffic-sources', 'Admin\\Analytics::getTrafficSources');
$routes->get('api/analytics/geo', 'Admin\\Analytics::getGeo');
$routes->get('api/analytics/device-category', 'Admin\\Analytics::getDeviceCategory');

$routes->get('auth/login', 'Auth\\Login::index');
$routes->post('auth/login', 'Auth\\Login::login');

$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('analytics/overview', 'Admin\\Analytics::index');
    $routes->get('analytics/top-pages', 'Admin\\Analytics::top_pages');
    $routes->get('analytics/traffic-sources', 'Admin\\Analytics::traffic_sources');
    $routes->get('analytics/geo', 'Admin\\Analytics::geo');
    $routes->get('analytics/device-category', 'Admin\\Analytics::device_category');
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->resource('posts', ['controller' => 'Admin\Posts']);
    $routes->post('posts/upload_image', 'Admin\Posts::upload_image');
    $routes->resource('categories', ['controller' => 'Admin\Categories']);
    $routes->resource('tags', ['controller' => 'Admin\Tags']);
    $routes->resource('users', ['controller' => 'Admin\Users', 'placeholder' => '(:num)', 'filter' => 'admin']);
    $routes->get('profile', 'Admin\Users::profile');
    $routes->get('settings', 'Admin\Users::settings');
    $routes->post('users/update_settings', 'Admin\Users::update_settings');
});
