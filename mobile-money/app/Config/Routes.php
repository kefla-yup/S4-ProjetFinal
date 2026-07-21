<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Client\AuthController::index');

// --------------------------------------------------------------
// Espace CLIENT
// --------------------------------------------------------------
$routes->group('client', function ($routes) {
    $routes->get('login', 'Client\AuthController::index');
    $routes->post('login', 'Client\AuthController::login');
    $routes->get('logout', 'Client\AuthController::logout');

    $routes->get('dashboard', 'Client\DashboardController::index');

    $routes->get('depot', 'Client\DashboardController::depotForm');
    $routes->post('depot', 'Client\DashboardController::depot');

    $routes->get('retrait', 'Client\DashboardController::retraitForm');
    $routes->post('retrait', 'Client\DashboardController::retrait');

    $routes->get('transfert', 'Client\DashboardController::transfertForm');
    $routes->post('transfert', 'Client\DashboardController::transfert');

    $routes->get('transfert-multiple', 'Client\DashboardController::transfertMultipleForm');
    $routes->post('transfert-multiple', 'Client\DashboardController::transfertMultiple');

    $routes->get('historique', 'Client\DashboardController::historique');
});

// --------------------------------------------------------------
// Espace OPERATEUR
// --------------------------------------------------------------
$routes->group('operateur', function ($routes) {
    $routes->get('login', 'Operateur\AuthController::index');
    $routes->post('login', 'Operateur\AuthController::login');
    $routes->get('logout', 'Operateur\AuthController::logout');

    $routes->get('dashboard', 'Operateur\DashboardController::index');

    // Configuration des préfixes
    $routes->get('prefixes', 'Operateur\PrefixeController::index');
    $routes->post('prefixes/add', 'Operateur\PrefixeController::add');
    $routes->get('prefixes/delete/(:num)', 'Operateur\PrefixeController::delete/$1');

    // Types d'opération + barèmes de frais
    $routes->get('operations', 'Operateur\OperationController::index');
    $routes->post('operations/bareme/add', 'Operateur\OperationController::addBareme');
    $routes->get('operations/bareme/delete/(:num)', 'Operateur\OperationController::deleteBareme/$1');
    $routes->get('operations/bareme/edit/(:num)', 'Operateur\OperationController::editBareme/$1');
    $routes->post('operations/bareme/modif/(:num)', 'Operateur\OperationController::modifBareme/$1');

    // Paramètres (commission externe)
    $routes->get('parametres', 'Operateur\ParametreController::index');
    $routes->post('parametres/update', 'Operateur\ParametreController::update');

    $routes->get('promotion', 'Operateur\ParametreController::promotion');
    $routes->post('promotion/update_promotion', 'Operateur\ParametreController::updatePromotion');

    // Situations
    $routes->get('situation/gains', 'Operateur\SituationController::gains');
    $routes->get('situation/clients', 'Operateur\SituationController::clients');
    $routes->get('situation/montants-a-envoyer', 'Operateur\SituationController::montantsAEnvoyer');
});
