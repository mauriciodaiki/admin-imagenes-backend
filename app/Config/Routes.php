<?php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::attemptRegister');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

$routes->get('imagenes', 'Imagenes::index');
$routes->post('imagenes/subir', 'Imagenes::subir');
$routes->post('imagenes/borrar/(:num)', 'Imagenes::borrar/$1');

$routes->group('user', ['filter' => 'auth'], function($routes) {
    $routes->get('', 'User::index');
    $routes->get('edit/(:num)', 'User::edit/$1');
    $routes->post('update/(:num)', 'User::update/$1');
    $routes->get('delete/(:num)', 'User::delete/$1');
});

$routes->get('admin/usuarios', 'Imagenes::adminPanel', ['filter' => 'admin']);
$routes->get('admin/eliminar/(:num)', 'Imagenes::eliminarUsuario/$1', ['filter' => 'admin']);