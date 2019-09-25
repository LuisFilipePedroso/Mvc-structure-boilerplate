<?php
require('./Router.php');
$router = new Router();
$router->get('/users', 'UserController::get');
$router->get('/users/:id', 'UserController::getById');
$router->run();