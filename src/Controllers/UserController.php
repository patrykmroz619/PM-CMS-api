<?php

declare (strict_types=1);

namespace Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Models\UserModel;
use Services\TokenService;
use Validators\UserDataValidator;

class UserController {
  private UserModel $userModel;
  private UserDataValidator $userDataValidator;

  public function __construct(UserModel $userModel, UserDataValidator $userDataValidator)
  {
    $this->userModel = $userModel;
    $this->userDataValidator = $userDataValidator;
  }

  public function signIn(Request $request, Response $response) {
    $body = $request->getParsedBody();
    $user = $this->userDataValidator->signInValidate($body, $this->userModel);

    $activeToken = TokenService::getActiveToken($user['uid']);
    $refreshToken = TokenService::getRefreshToken($user['uid']);

    $this->userModel->update(
      ['email' => $user['email']],
      ['refreshToken' => $refreshToken]
    );

    $userData = [
      'uid' => $user['uid'],
      'email' => $user['email'],
      'password' => $user['password'],
      'activeToken' => $activeToken,
      'refreshToken' => $refreshToken
    ];

    $response->getBody()->write(json_encode($userData));

    return $response;
  }

  public function signUp(Request $request, Response $response) {
    $body = $request->getParsedBody();
    $this->userDataValidator->signUpValidate($body, $this->userModel);

    $uid = uniqid();
    $activeToken = TokenService::getActiveToken($uid);
    $refreshToken = TokenService::getRefreshToken($uid);

    $userData = [
      'uid' => $uid,
      'email' => $body['email'],
      'password' => password_hash($body['password'], PASSWORD_DEFAULT),
      'refreshToken' => $refreshToken
    ];

    $this->userModel->insertOne($userData);

    $userData['activeToken'] = $activeToken;
    $response->getBody()->write(json_encode($userData));

    return $response;
  }
}
