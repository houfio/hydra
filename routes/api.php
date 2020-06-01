<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->group(['prefix' => '/auth'], function () use ($router) {
    $router->post('login', 'AuthController@authenticate');
});

$router->get('/menu', 'MenuController@list');

$router->group(['prefix' => '/dish'], function () use ($router) {
    $router->post('', 'DishController@create');
    $router->get('{dish}', 'DishController@detail');
    $router->patch('{dish}', 'DishController@update');
    $router->delete('{dish}', 'DishController@delete');
});
