<?php

$router = $di->getRouter();

// Define your routes here
$router->add(
    '/api/v1/users',
    [
        'namespace'  => 'SmileTrunk\Controllers',
        'controller' => 'Users',
        'action'     => 'index',
    ]
);

$router->handle($_SERVER['REQUEST_URI']);
