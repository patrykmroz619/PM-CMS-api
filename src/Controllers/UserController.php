<?php

declare(strict_types=1);

namespace Controllers;

use Models\UserModel;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Services\TokenService;

class UserController {
  private UserModel $userModel;

  public function __construct(UserModel $userModel)
  {
    $this->userModel = $userModel;
  }

  public function getActiveUser(Request $request, Response $response): Response
  {
    $token = TokenService::getTokenFromRequest($request);
    $arrayToken = (array) TokenService::validateToken($token);

    $uid = $arrayToken['uid'];
    $user = $this->userModel->findOne(['uid' => $uid]);

    $responseData = [
      'uid' => $user['uid'],
      'email' => $user['email'],
      'name' => $user['name'] ?? null,
      'surname' => $user['surname'] ?? null,
      'company' => $user['company'] ?? null
    ];

    $response->getBody()->write(json_encode($responseData));
    return $response;
  }
}
