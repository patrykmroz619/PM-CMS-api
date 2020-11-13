<?php

declare(strict_types=1);

use Controllers\UserController;
use Controllers\MainController;
use Middlewares\AuthMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
  $app->post('/login', [UserController::class, 'signIn']);
  $app->post('/register', [UserController::class, 'signUp']);

  $app->group('', function (RouteCollectorProxy $group) {
    $group->get('/', [MainController::class, 'hello']);
  })->add(new AuthMiddleware());
};
