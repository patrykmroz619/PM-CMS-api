<?php

declare(strict_types=1);

namespace Api\Services;

use Api\Models\UserModel;

class UserService {
  private UserModel $userModel;

  public function __construct()
  {
    $this->userModel = new UserModel();
  }

  public function getUserWithUidFromToken(string $token): array
  {
    $arrayToken = (array) TokenService::validateToken($token);

    $uid = $arrayToken['uid'];
    $user = $this->userModel->findOne(['uid' => $uid]);

    $userData = [
      'uid' => $user['uid'],
      'email' => $user['email'],
      'name' => $user['name'] ?? null,
      'surname' => $user['surname'] ?? null,
      'company' => $user['company'] ?? null
    ];

    return $userData;
  }
}
