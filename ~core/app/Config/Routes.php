<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('/login', 'Login::proses');
$routes->post('/admin/user/new', 'Admin/User::save');
$routes->post('/admin/user/edit/(:num)', 'Admin/User::save');

$routes->post('/admin/siswa/new', 'Admin/Siswa::save');
$routes->post('/admin/siswa/edit/(:num)', 'Admin/Siswa::save');
$routes->post('/admin/ortu/new', 'Admin/Ortu::save');
$routes->post('/admin/ortu/edit/(:num)', 'Admin/Ortu::save');

$routes->post('/admin/kantin/new', 'Admin/Kantin::save');
$routes->post('/admin/kantin/edit/(:num)', 'Admin/Kantin::save');

$routes->post('/kantin/barang/new', 'Kantin/Barang::save');
$routes->post('/kantin/barang/edit/(:num)', 'Kantin/Barang::save');

$routes->post('/admin/setting', 'Admin/Setting::save');

$routes->group('admin/database', function ($routes) {
    $routes->get('', 'Admin\Database::index');
    $routes->get('table/(:segment)', 'Admin\Database::table/$1');
    $routes->get('create/(:segment)', 'Admin\Database::create/$1');
    $routes->post('save_row/(:segment)', 'Admin\Database::save_row/$1');
    $routes->get('edit/(:segment)', 'Admin\Database::edit/$1');
    $routes->post('update_row/(:segment)', 'Admin\Database::update_row/$1');
    $routes->get('delete_row/(:segment)', 'Admin\Database::delete_row/$1');
    $routes->match(['get', 'post'], 'query', 'Admin\Database::query');
    $routes->get('backup', 'Admin\Database::backup');
});

$routes->post('/admin/profile', 'Admin/Profile::save');
$routes->post('/admin/profile/password', 'Admin/Profile::save_password');

$routes->post('/petugas/profile', 'Admin/Profile::save');
$routes->post('/petugas/profile/password', 'Admin/Profile::save_password');
$routes->post('/petugas/deposit/new', 'Petugas/Deposit::save');

$routes->post('/kantin/profile', 'Admin/Profile::save');
$routes->post('/kantin/profile/password', 'Admin/Profile::save_password');

$routes->post('/super/profile', 'Admin/Profile::save');
$routes->post('/super/profile/password', 'Admin/Profile::save_password');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
