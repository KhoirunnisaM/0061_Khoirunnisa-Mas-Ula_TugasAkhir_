<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::index'); // Halaman login
$routes->post('/login', 'Auth::login'); // Proses login
$routes->get('/logout', 'Auth::logout'); // Proses logout

// Routing dengan level akses
$routes->group('Admin', ['filter' => 'level:admin'], function ($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
});

$routes->group('Pegawai', ['filter' => 'level:pegawai'], function ($routes) {
    $routes->get('dashboard', 'Pegawai::dashboard');
});
