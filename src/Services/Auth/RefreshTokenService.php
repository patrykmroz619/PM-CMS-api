<?php

declare(strict_types=1);

namespace Api\Services\Auth;

use Api\AppExceptions\AuthExceptions\InvalidRefreshTokenException;
use Api\Models\User\UserModel;
use Api\Services\TokenService;

class RefreshTokenService extends AbstractAuthService
{
  private UserModel $userModel;

  public function __construct()
  {
    $this->userModel = new UserModel();
  }

  public function refreshToken(string $token): array
  {
    $validToken = $this->validateRefreshToken($token);

    $uid = $validToken['uid'];
    $tokens = $this->getTokens($uid);
    $this->userModel->update($uid, ['refreshToken' => $tokens['refreshToken']]);

    return $tokens;
  }

  private function validateRefreshToken(string $token): array
  {
    $validToken = TokenService::validateToken($token);

    if(!$validToken || $validToken['access'])
      throw new InvalidRefreshTokenException();

    $uid = $validToken['uid'];
    $user = $this->userModel->findById($uid);

    if($user['refreshToken'] != $token)
      throw new InvalidRefreshTokenException();

    return $validToken;
  }
}
