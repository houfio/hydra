<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->group(['prefix' => '/auth'], function () use ($router) {
    $router->post('login', 'AuthController@authenticate');
    $router->post('tablet', 'AuthController@session');
});

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => '/orders'], function () use ($router) {
        $router->get('', 'OrderController@list');
        $router->post('', 'OrderController@create');
    });
});

$router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->group(['prefix' => '/dishes'], function () use ($router) {
        $router->get('', 'DishController@list');
        $router->post('', 'DishController@create');
        $router->get('{dish}', 'DishController@detail');
        $router->put('{dish}', 'DishController@update');
        $router->delete('{dish}', 'DishController@delete');
    });

    $router->group(['prefix' => '/types'], function () use ($router) {
        $router->get('', 'TypeController@list');
        $router->post('', 'TypeController@create');
        $router->get('{dishtype}', 'TypeController@detail');
        $router->put('{dishtype}', 'TypeController@update');
        $router->delete('{dishtype}', 'TypeController@delete');
    });

    $router->get('/report', 'ReportController@create');

    $router->group(['prefix' => '/orders'], function () use ($router) {
        $router->get('{order}', 'OrderController@detail');
    });

    $router->group(['prefix' => '/offers'], function () use ($router) {
        $router->get('', 'OfferController@list');
        $router->post('', 'OfferController@create');
        $router->get('{offer}', 'OfferController@detail');
        $router->delete('{offer}', 'OfferController@delete');
    });
});

$router->group(['prefix' => '/menu'], function () use ($router) {
    $router->get('', 'MenuController@list');
    $router->get('download', 'MenuController@download');
});
