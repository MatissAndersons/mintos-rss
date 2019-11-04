<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */
$router->get('/{route:.*}', function () use ($router) {
    return view('main');
});

$router->group(
    [
        'namespace' => 'Api',
        'prefix' => 'api'
    ],
    function () use ($router) {
        $router->group(['namespace' => 'User'], function () use ($router) {
            $router->post('/login', 'Login@login');
            $router->post('/register', 'Register@register');
            $router->post('/check-email', 'CheckEmail@exists');
        });

        $router->group(['namespace' => 'Feed'], function () use ($router) {
            $router->post('/feed', 'Index@getFeed');
        });
    }
);
