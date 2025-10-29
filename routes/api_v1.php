<?php

/** @var \Laravel\Lumen\Routing\Router $router */

// Logga in
$router->post('/login', 'AuthController@login');

// Refreshtoken hantering
$router->get('/refresh', 'AuthController@refresh');
