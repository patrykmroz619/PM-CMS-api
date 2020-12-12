<?php

declare(strict_types=1);

namespace Api\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Api\Services\UserService;

class UserController {
  private UserService $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function getActiveUser(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $user = $this->userService->getUser($body['uid']);

    $userData = [
      'uid' => $user['uid'],
      'email' => $user['email'],
      'name' => $user['name'] ?? null,
      'surname' => $user['surname'] ?? null,
      'company' => $user['company'] ?? null
    ];

    $response->getBody()->write(json_encode($userData));
    return $response;
  }

  public function updateUserData(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $updatedUser = $this->userService->updateUserData($body);

    $response->getBody()->write(json_encode($updatedUser));
    return $response;
  }

  public function deleteUser(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $this->userService->deleteUser($body['uid']);
    return $response->withStatus(204);
  }
}
