<?php

declare(strict_types=1);

namespace Api\App;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Api\Controllers\AuthController;
use Api\Controllers\MainController;
use Api\Controllers\UserController;
use Api\Controllers\ProjectController;
use Api\Middlewares\AuthMiddleware;

return function (App $app) {
  $app->post('/login', [AuthController::class, 'signIn']);
  $app->post('/register', [AuthController::class, 'signUp']);
  $app->post('/refresh', [AuthController::class, 'refreshToken']);

  $app->group('', function (RouteCollectorProxy $group) {
    $group->get('/', [MainController::class, 'hello']);
    $group->get('/me', [UserController::class, 'getActiveUser']);

    $group->get('/projects', [ProjectController::class, 'getProjects']);
    $group->post('/projects', [ProjectController::class, 'addProject']);
    $group->get('/projects/{id}', [ProjectController::class, 'getProjectById']);
    $group->put('/projects/{id}', [ProjectController::class, 'updateProject']);
    $group->delete('/projects/{id}', [ProjectController::class, 'deleteProject']);
  })->add(new AuthMiddleware());
};
