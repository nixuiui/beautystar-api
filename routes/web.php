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

/*-------------------------------------------
| AUTH CONTROLLER
-------------------------------------------*/
$router->group(['prefix' => 'auth'], function ($router) {
    $router->post('login',      'AuthController@login');
    $router->post('username',   'AuthController@username');
    $router->post('email',      'AuthController@email');
    $router->post('me',         ['uses' => 'AuthController@me', 'middleware' => 'auth']);
    $router->get('logout',      ['uses' => 'AuthController@logout', 'middleware' => 'auth']);
});


$router->group(['prefix' => 'muadashboard', 'namespace' => 'MuaDashboard'], function ($router) {
    
    $router->get('/',           ['uses' => 'MuaController@muaInformation', 'middleware' => 'auth']);
    $router->post('/edit',      ['uses' => 'MuaController@muaEdit', 'middleware' => 'auth']);
    $router->get('/summary',    ['uses' => 'MuaController@summary', 'middleware' => 'auth']);
    
    /*-------------------------------------------
    | SERVICES
    -------------------------------------------*/
    $router->get('/services',               ['uses' => 'MuaController@services', 'middleware' => 'auth']);
    $router->post('/services/create',       ['uses' => 'MuaController@serviceCreate', 'middleware' => 'auth']);
    $router->post('/services/{id}/edit',    ['uses' => 'MuaController@serviceCreate', 'middleware' => 'auth']);
    $router->get('/services/{id}',          ['uses' => 'MuaController@serviceDetail', 'middleware' => 'auth']);
    $router->get('/services/{id}/delete',   ['uses' => 'MuaController@serviceDelete', 'middleware' => 'auth']);
    
    /*-------------------------------------------
    | PORTFOLIOS
    -------------------------------------------*/
    $router->get('/portfolio',              ['uses' => 'MuaController@portfolio', 'middleware' => 'auth']);
    $router->get('/portfolio/{id}/delete',  ['uses' => 'MuaController@portfolioDelete', 'middleware' => 'auth']);
    $router->post('/portfolio/upload',      ['uses' => 'MuaController@portfolioUpload', 'middleware' => 'auth']);
    
    /*-------------------------------------------
    | ORDERS
    -------------------------------------------*/
    $router->get('/order/new',              ['uses' => 'OrderController@orderNewest', 'middleware' => 'auth']);
    $router->get('/order/going',            ['uses' => 'OrderController@orderOnGoing', 'middleware' => 'auth']);
    $router->get('/order/finish',           ['uses' => 'OrderController@orderFinished', 'middleware' => 'auth']);
    $router->get('/order/cancel',           ['uses' => 'OrderController@orderCanceled', 'middleware' => 'auth']);
    $router->get('/order/detail/{id}',      ['uses' => 'OrderController@detailOrder', 'middleware' => 'auth']);
    $router->post('/order/approval/{id}',   ['uses' => 'OrderController@approvalOrder', 'middleware' => 'auth']);
    $router->post('/order/complete/{id}',   ['uses' => 'OrderController@completeOrder', 'middleware' => 'auth']);
    $router->get('/order/cancel/{id}',      ['uses' => 'OrderController@cancel', 'middleware' => 'auth']);

    /*-------------------------------------------
    | SCHEDULE
    -------------------------------------------*/
    $router->get('/schedules',             ['uses' => 'ScheduleController@index', 'middleware' => 'auth']);
    $router->get('/schedule/delete/{id}',  ['uses' => 'ScheduleController@deteleSchedule', 'middleware' => 'auth']);
    $router->get('/schedule/detail/{id}',  ['uses' => 'ScheduleController@detail', 'middleware' => 'auth']);
    $router->post('/schedule/create',      ['uses' => 'ScheduleController@create', 'middleware' => 'auth']);
    $router->post('/schedule/edit/{id}',   ['uses' => 'ScheduleController@edit', 'middleware' => 'auth']);

    /*-------------------------------------------
    | FEEDBACK
    -------------------------------------------*/
    $router->get('/feedbacks',  ['uses' => 'FeedbackController@index', 'middleware' => 'auth']);

    /*-------------------------------------------
    | SETTINGS
    -------------------------------------------*/
    $router->post('/setting/general',   ['uses' => 'SettingController@index', 'middleware' => 'auth']);

    /*-------------------------------------------
    | DOWNPAYMENT
    -------------------------------------------*/
    $router->get('/downpayments',             ['uses' => 'DownpaymentController@index', 'middleware' => 'auth']);
    $router->get('/downpayment/delete/{id}',  ['uses' => 'DownpaymentController@detele', 'middleware' => 'auth']);
    $router->get('/downpayment/detail/{id}',  ['uses' => 'DownpaymentController@detail', 'middleware' => 'auth']);
    $router->post('/downpayment/create',      ['uses' => 'DownpaymentController@create', 'middleware' => 'auth']);
    $router->post('/downpayment/edit/{id}',   ['uses' => 'DownpaymentController@edit', 'middleware' => 'auth']);

});

$router->group(['prefix' => 'profile', 'namespace' => 'Profile'], function ($router) {
    $router->get('/accountinformation', ['uses' => 'ProfileController@accountInformation', 'middleware' => 'auth']);
    $router->get('/income',             ['uses' => 'ProfileController@income', 'middleware' => 'auth']);
    $router->post('/edit/password',     ['uses' => 'ProfileController@editPassword', 'middleware' => 'auth']);
    $router->post('/edit/general',      ['uses' => 'ProfileController@editGeneral', 'middleware' => 'auth']);

    /*-------------------------------------------
    | ADDRESS
    -------------------------------------------*/
    $router->get('/addresses',            ['uses' => 'AddressController@index', 'middleware' => 'auth']);
    $router->get('/address/detail/{id}',  ['uses' => 'AddressController@detail', 'middleware' => 'auth']);
    $router->get('/address/delete/{id}',  ['uses' => 'AddressController@detele', 'middleware' => 'auth']);
    $router->post('/address/create',      ['uses' => 'AddressController@create', 'middleware' => 'auth']);
    $router->post('/address/edit/{id}',   ['uses' => 'AddressController@edit', 'middleware' => 'auth']);

    /*-------------------------------------------
    | BANK
    -------------------------------------------*/
    $router->get('/banks',              ['uses' => 'BankController@index', 'middleware' => 'auth']);
    $router->get('/bank/detail/{id}',   ['uses' => 'BankController@detail', 'middleware' => 'auth']);
    $router->get('/bank/delete/{id}',   ['uses' => 'BankController@detele', 'middleware' => 'auth']);
    $router->post('/bank/create',       ['uses' => 'BankController@create', 'middleware' => 'auth']);
    $router->post('/bank/edit/{id}',    ['uses' => 'BankController@edit', 'middleware' => 'auth']);
});

$router->group(['prefix' => 'masterdata'], function ($router) {
    $router->get('/service-categories',         ['uses' => 'MasterController@serviceCategories']);
    // $router->get('/service-subcategories',      ['uses' => 'MasterController@serviceCategories']);
    $router->get('/province',                   ['uses' => 'MasterController@province']);
    $router->get('/city',                       ['uses' => 'MasterController@city']);
    $router->get('/city',                       ['uses' => 'MasterController@city']);
    $router->get('/city',                       ['uses' => 'MasterController@city']);
});
