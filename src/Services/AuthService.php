<?php

declare(strict_types=1);

namespace Api\Services;

use Api\AppExceptions\AuthExceptions\InvalidRefreshTokenException;
use Api\AppExceptions\SignInExceptions\UserNotFoundException;
use Api\AppExceptions\SignUpExceptions\UserAlreadyExistsException;
use Api\Models\UserModel;
use Api\Validators\UserDataValidator;
use MongoDB\Model\BSONDocument;

class AuthService {
  private UserModel $userModel;
  private UserDataValidator $validator;

  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->validator = new UserDataValidator();
  }

  public function signIn(array $signInData): array
  {
    $userData = $this->validator->signInValidate($signInData);

    $user = $this->getUser($userData);
    if (!$user) throw new UserNotFoundException();

    $activeToken = TokenService::getActiveToken($user['uid']);
    $refreshToken = TokenService::getRefreshToken($user['uid']);

    $this->userModel->update(
      ['email' => $user['email'], 'uid' => $user['uid']],
      ['refreshToken' => $refreshToken]
    );

    return $this->createResponse((array) $user, $activeToken, $refreshToken);
  }

  public function signUp(array $signUpData): array
  {
    $userData = $this->validator->signUpValidate($signUpData);

    $isUserExist = $this->checkThatUserExist($userData);
    if($isUserExist) throw new UserAlreadyExistsException();

    $uid = uniqid();

    $dataToSave = [
      'uid' => $uid,
      'email' => $userData['email'],
      'name' => $userData['name'],
      'surname' => $userData['surname'],
      'company' => $userData['company'],
      'password' => password_hash($userData['password'], PASSWORD_DEFAULT)
    ];

    $this->userModel->insertOne($dataToSave);

    $activeToken = TokenService::getActiveToken($uid);
    $refreshToken = TokenService::getRefreshToken($uid);

    return $this->createResponse($dataToSave, $activeToken, $refreshToken);
  }

  public function refreshToken(string $token): array
  {
    $arrayToken = (array) TokenService::validateToken($token);

    if(!empty($arrayToken) && !$arrayToken['active']) {
      $uid = $arrayToken['uid'];
      $user = $this->userModel->findOne(['uid' => $uid]);

      if($user['refreshToken'] == $token) {
        $newActiveToken = TokenService::getActiveToken($uid);
        $newRefreshToken = TokenService::getRefreshToken($uid);

        $this->userModel->update(['uid' => $uid], ['refreshToken' => $newRefreshToken]);

        $newTokens = [
          'activeToken' => $newActiveToken,
          'refreshToken' => $newRefreshToken
        ];

        return $newTokens;
      }
    }

    throw new InvalidRefreshTokenException();
  }

  private function checkThatUserExist(array $userData): bool
  {
    $user = $this->getUser($userData);

    return !!$user;
  }

  private function getUser($userData): ?BSONDocument
  {
    return $this->userModel->findOne(['email' => $userData['email']]);
  }

  private function createResponse(array $user, string $activeToken, string $refreshToken): array
  {
    return [
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
  }
}
