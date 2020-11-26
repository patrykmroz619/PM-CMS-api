<?php

declare(strict_types=1);

use Controllers\AuthController;
use Controllers\MainController;
use Controllers\UserController;
use Middlewares\AuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->post('/login', [AuthController::class, 'signIn']);
  $app->post('/register', [AuthController::class, 'signUp']);
  $app->post('/refresh', [AuthController::class, 'refreshToken']);

  $app->group('', function (RouteCollectorProxy $group) {
    $group->get('/', [MainController::class, 'hello']);
    $group->get('/activeUser', [UserController::class, 'getActiveUser']);
  })->add(new AuthMiddleware());
};
