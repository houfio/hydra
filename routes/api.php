<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->group(['prefix' => '/auth'], function () use ($router) {
    $router->post('login', 'AuthController@authenticate');
});

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => '/dish', 'middleware' => 'auth'], function () use ($router) {
        $router->post('', 'DishController@create');
        $router->get('{dish}', 'DishController@detail');
        $router->patch('{dish}', 'DishController@update');
        $router->delete('{dish}', 'DishController@delete');
    });

    $router->get('/report', 'ReportController@create');
});

$router->get('/menu', 'MenuController@list');
