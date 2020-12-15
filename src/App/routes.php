<?php

declare(strict_types=1);

namespace Api\App;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Api\Controllers\AuthController;
use Api\Controllers\ContentModelController;
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
    $group->get('/users', [UserController::class, 'getActiveUser']);
    $group->put('/users', [UserController::class, 'updateUserData']);
    $group->delete('/users', [UserController::class, 'deleteUser']);

    $group->get('/projects', [ProjectController::class, 'getProjects']);
    $group->post('/projects', [ProjectController::class, 'addProject']);
    $group->get('/projects/{id}', [ProjectController::class, 'getProjectById']);
    $group->put('/projects/{id}', [ProjectController::class, 'updateProject']);
    $group->delete('/projects/{id}', [ProjectController::class, 'deleteProject']);

    $group->get('/content-models/{projectId}', [ContentModelController::class, 'getContentModels']);
    $group->post('/content-models/{projectId}', [ContentModelController::class, 'createContentModel']);
    $group->put('/content-models/{contentModelId}', [ContentModelController::class, 'updateContentModel']);
    $group->delete('/content-models/{contentModelId}', [ContentModelController::class, 'deleteContentModel']);
  })->add(new AuthMiddleware());
};
