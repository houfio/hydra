<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->group(['prefix' => '/auth'], function () use ($router) {
    $router->post('login', 'AuthController@authenticate');
    $router->post('tablet', 'AuthController@session');
});

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => '/order'], function () use ($router) {
        $router->get('', 'OrderController@list');
        $router->post('', 'OrderController@create');
    });
});

$router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->group(['prefix' => '/dish'], function () use ($router) {
        $router->post('', 'DishController@create');
        $router->get('{dish}', 'DishController@detail');
        $router->patch('{dish}', 'DishController@update');
        $router->delete('{dish}', 'DishController@delete');
    });

    $router->get('/report', 'ReportController@create');

    $router->group(['prefix' => '/order'], function () use ($router) {
        $router->get('{order}', 'OrderController@detail');
    });

    $router->group(['prefix' => '/deal'], function () use ($router) {
        $router->get('', 'DealController@list');
        $router->post('', 'DealController@create');
        $router->get('{deal}', 'DealController@detail');
        $router->delete('{deal}', 'DealController@delete');
    });
});

$router->get('/dish', 'DishController@list');
