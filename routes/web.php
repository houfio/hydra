<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->get('/{any:.*}', function () {
    return view('app');
});
