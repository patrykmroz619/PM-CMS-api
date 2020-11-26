<?php

declare (strict_types=1);

namespace Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Models\UserModel;
use Services\TokenService;
use Validators\UserDataValidator;

class AuthController {
  private UserModel $userModel;
  private UserDataValidator $userDataValidator;

  public function __construct(UserModel $userModel, UserDataValidator $userDataValidator)
  {
    $this->userModel = $userModel;
    $this->userDataValidator = $userDataValidator;
  }

  public function signIn(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();
    $user = $this->userDataValidator->signInValidate($body, $this->userModel);

    $activeToken = TokenService::getActiveToken($user['uid']);
    $refreshToken = TokenService::getRefreshToken($user['uid']);

    $this->userModel->update(
      ['email' => $user['email'], 'uid' => $user['uid']],
      ['refreshToken' => $refreshToken]
    );

    $responseData = [
      'userData' => [
        'uid' => $user['uid'],
        'email' => $user['email'],
        'name' => $user['name'] ?? null,
        'surname' => $user['surname'] ?? null,
        'company' => $user['company'] ?? null
      ],
      'tokens' => [
        'activeToken' => $activeToken,
        'refreshToken' => $refreshToken
      ]
    ];

    $response->getBody()->write(json_encode($responseData));

    return $response;
  }

  public function signUp(Request $request, Response $response): Response
  {
    $body = $request->getParsedBody();
    $this->userDataValidator->signUpValidate($body, $this->userModel);

    $uid = uniqid();

    $userData = [
      'uid' => $uid,
      'email' => $body['email'],
      'name' => $body['name'],
      'surname' => $body['surname'],
      'company' => $body['company'],
      'password' => password_hash($body['password'], PASSWORD_DEFAULT)
    ];

    $this->userModel->insertOne($userData);

    $activeToken = TokenService::getActiveToken($uid);
    $refreshToken = TokenService::getRefreshToken($uid);

    $responseData = [
      'userData' => [
        'uid' => $userData['uid'],
        'email' => $userData['email'],
        'name' => $userData['name'] ?? null,
        'surname' => $userData['surname'] ?? null,
        'company' => $userData['company'] ?? null
      ],
      'tokens' => [
        'activeToken' => $activeToken,
        'refreshToken' => $refreshToken
      ]
    ];

    $response->getBody()->write(json_encode($responseData));

    return $response;
  }

  public function refreshToken(Request $request, Response $response): Response
  {
    $authHeader = $request->getHeader('Authorization');
    $token = isset($authHeader[0]) ? substr($authHeader[0], 7) : '';

    $arrayToken = (array) TokenService::validateToken($token);

    if(!empty($arrayToken) && !$arrayToken['active']) {
      $uid = $arrayToken['uid'];
      $user = $this->userModel->findOne(['uid' => $uid]);

      if($user['refreshToken'] == $token) {
        $newActiveToken = TokenService::getActiveToken($uid);
        $newRefreshToken = TokenService::getRefreshToken($uid);

        $this->userModel->update(['uid' => $uid], ['refreshToken' => $newRefreshToken]);

        $response->getBody()->write(json_encode([
          'activeToken' => $newActiveToken,
          'refreshToken' => $newRefreshToken
        ]));
      }
    }

    return $response->withStatus(401);
  }
}
