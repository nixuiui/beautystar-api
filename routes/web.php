<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// -------------------------------------------
// AUTH CONTROLLER
// -------------------------------------------
$router->group(['prefix' => 'auth'], function ($router) {
    $router->post('login',      'AuthController@login');
    $router->post('username',   'AuthController@username');
    $router->post('email',      'AuthController@email');
    $router->post('me',         ['uses' => 'AuthController@me', 'middleware' => 'auth']);
    $router->get('logout',      ['uses' => 'AuthController@logout', 'middleware' => 'auth']);
});

$router->group(['prefix' => 'muadashboard', 'namespace' => 'MuaDashboard'], function ($router) {
    $router->get('/',                       ['uses' => 'MuaController@muaInformation', 'middleware' => 'auth']);
    $router->get('/services',               ['uses' => 'MuaController@services', 'middleware' => 'auth']);
    $router->post('/services/create',       ['uses' => 'MuaController@serviceCreate', 'middleware' => 'auth']);
    $router->get('/services/{id}',          ['uses' => 'MuaController@serviceDetail', 'middleware' => 'auth']);
    $router->get('/services/{id}/delete',   ['uses' => 'MuaController@serviceDelete', 'middleware' => 'auth']);
});

$router->group(['prefix' => 'masterdata'], function ($router) {
    $router->get('/mua-service-categories',     ['uses' => 'MasterController@muaServiceCategories']);
});