<?php

declare(strict_types=1);

namespace Api\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Api\Models\UserModel;

class UserController {
  private UserModel $userModel;

  public function __construct(UserModel $userModel)
  {
    $this->userModel = $userModel;
  }

  public function getActiveUser(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();

    $user = $this->userModel->findOne(['uid' => $body['uid']]);

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
}
