<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->post('/autentikasi', 'Auth::autentikasi');
$routes->get('/auth/logout', 'Auth::logout');
