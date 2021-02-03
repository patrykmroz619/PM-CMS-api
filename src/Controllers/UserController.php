<?php

declare(strict_types=1);

namespace Api\Controllers;

use Api\Services\User\PasswordService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Api\Services\User\UserService;

class UserController {
  private UserService $userService;
  private PasswordService $passwordService;

  public function __construct(UserService $userService, PasswordService $passwordService)
  {
    $this->userService = $userService;
    $this->passwordService = $passwordService;
  }

  public function getActiveUser(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $user = $this->userService->getUser($body['uid']);

    $userData = [
      'id' => $user['id'],
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
    return $response->withStatus(201);
  }

  public function deleteUser(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $this->userService->deleteUser($body['uid']);
    return $response->withStatus(204);
  }

  public function changePassword(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $this->passwordService->updatePassword(
      $body['uid'],
      $body['currentPassword'] ?? null,
      $body['newPassword'] ?? null
    );

    return $response->withStatus(201);
  }
}
