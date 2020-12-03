<?php

declare(strict_types=1);

namespace Api\App;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Api\Controllers\AuthController;
use Api\Controllers\MainController;
use Api\Controllers\UserController;
use Api\Middlewares\AuthMiddleware;

return function (App $app) {
  $app->post('/login', [AuthController::class, 'signIn']);
  $app->post('/register', [AuthController::class, 'signUp']);
  $app->post('/refresh', [AuthController::class, 'refreshToken']);

  $app->group('', function (RouteCollectorProxy $group) {
    $group->get('/', [MainController::class, 'hello']);
    $group->get('/activeUser', [UserController::class, 'getActiveUser']);
  })->add(new AuthMiddleware());
};
