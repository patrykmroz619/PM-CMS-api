<?php

declare(strict_types=1);

namespace Api\App;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Api\Controllers\AuthController;
use Api\Controllers\ContentModelController;
use Api\Controllers\ContentFieldController;
use Api\Controllers\GeneratedApiController;
use Api\Controllers\UserController;
use Api\Controllers\ProjectController;
use Api\Controllers\RecordController;
use Api\Middlewares\GeneratedApiAuthMiddleware;
use Api\Middlewares\PanelAuthMiddleware;

return function (App $app) {
  $app->post('/login', [AuthController::class, 'signIn']);
  $app->post('/register', [AuthController::class, 'signUp']);
  $app->post('/refresh', [AuthController::class, 'refreshToken']);

  $app->group('', function(RouteCollectorProxy $group) {
    $group->post('/logout', [AuthController::class, 'logout']);

    $group->get('/users', [UserController::class, 'getActiveUser']);
    $group->patch('/users', [UserController::class, 'updateUserData']);
    $group->delete('/users', [UserController::class, 'deleteUser']);
    $group->put('/users/password', [UserController::class, 'changePassword']);

    $group->get('/projects', [ProjectController::class, 'getProjects']);
    $group->post('/projects', [ProjectController::class, 'createProject']);
    $group->get('/projects/{id}', [ProjectController::class, 'getProjectById']);
    $group->patch('/projects/{id}', [ProjectController::class, 'updateProject']);
    $group->delete('/projects/{id}', [ProjectController::class, 'deleteProject']);
    $group->post('/projects/api-key/{id}', [ProjectController::class, 'generateApiKey']);

    $group->get('/content-models/{projectId}', [ContentModelController::class, 'getContentModels']);
    $group->post('/content-models/{projectId}', [ContentModelController::class, 'createContentModel']);
    $group->patch('/content-models/{contentModelId}', [ContentModelController::class, 'updateContentModel']);
    $group->delete('/content-models/{contentModelId}', [ContentModelController::class, 'deleteContentModel']);

    $group->post('/content-model-fields/{contentModelId}', [ContentFieldController::class, 'addField']);
    $group->put('/content-model-fields/{contentModelId}', [ContentFieldController::class, 'updateField']);
    $group->delete('/content-model-fields/{contentModelId}', [ContentFieldController::class, 'deleteField']);

    $group->get('/records/{contentModelId}', [RecordController::class, 'getRecords']);
    $group->post('/records/{contentModelId}', [RecordController::class, 'addRecord']);
    $group->put('/records/{recordId}', [RecordController::class, 'updateRecord']);
    $group->delete('/records/{recordId}', [RecordController::class, 'deleteRecord']);
  })->add(new PanelAuthMiddleware());

  $app->group('/api', function(RouteCollectorProxy $group) {
    $group->get('/{endpoint}', [GeneratedApiController::class, 'list']);
    $group->get('/{endpoint}/{recordId}', [GeneratedApiController::class, 'get']);
  })->add(new GeneratedApiAuthMiddleware());
};
