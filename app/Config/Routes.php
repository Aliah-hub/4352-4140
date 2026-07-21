<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');

$routes->get('login',             'AuthController::loginForm');
$routes->post('login/client',     'AuthController::loginClient');
$routes->post('login/operateur',  'AuthController::loginOperateur');
$routes->get('logout',            'AuthController::logout');

$routes->group('client', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard',         'Client\DashboardController::index');
    $routes->get('operations',        'Client\OperationController::formulaire');
    $routes->post('operations',       'Client\OperationController::effectuer');
    $routes->get('historique',        'Client\OperationController::historique');
    
    $routes->get('epargne',              'Client\EpargneController::index');
    $routes->post('epargne/action',      'Client\EpargneController::action');
});

$routes->group('operateur', ['filter' => 'admin'], static function ($routes) {
    $routes->get('dashboard',         'Operateur\DashboardController::index');

    $routes->get('prefixes',          'Operateur\PrefixeController::index');
    $routes->post('prefixes/store',   'Operateur\PrefixeController::store');
    $routes->post('prefixes/toggle/(:num)', 'Operateur\PrefixeController::toggleActif/$1');
    $routes->post('prefixes/delete/(:num)', 'Operateur\PrefixeController::delete/$1');

    $routes->get('type-operations',   'Operateur\TypeOperationController::index');
    $routes->post('type-operations/store',          'Operateur\TypeOperationController::store');
    $routes->post('type-operations/delete/(:num)',  'Operateur\TypeOperationController::delete/$1');

    $routes->get('type-operations/(:num)/baremes',             'Operateur\TypeOperationController::baremes/$1');
    $routes->post('type-operations/(:num)/baremes/store',      'Operateur\TypeOperationController::storeBareme/$1');
    $routes->post('type-operations/(:num)/baremes/update/(:num)', 'Operateur\TypeOperationController::updateBareme/$1/$2');
    $routes->post('type-operations/(:num)/baremes/delete/(:num)', 'Operateur\TypeOperationController::deleteBareme/$1/$2');

    $routes->get('gains',             'Operateur\GainController::index');

    $routes->get('config',            'Operateur\ConfigController::index');
    $routes->post('config/update',    'Operateur\ConfigController::update');

    $routes->get('clients',           'Operateur\ClientsController::index');
    $routes->get('clients/(:num)',    'Operateur\ClientsController::show/$1');
});
