<?php

declare(strict_types=1);

namespace Api\Services\Auth;

use Api\Services\TokenService;

abstract class AbstractAuthService
{
  protected function getTokens(string $userId): array
  {
    $accessToken = TokenService::getAccessToken($userId);
    $refreshToken = TokenService::getRefreshToken($userId);

    $tokens = [
      'accessToken' => $accessToken,
      'refreshToken' => $refreshToken
    ];

    return $tokens;
  }

  protected function createResponse(array $userData, array $tokens): array
  {
    return [
      'userData' => [
        'id' => $userData['id'],
        'email' => $userData['email'],
        'name' => $userData['name'] ?? null,
        'surname' => $userData['surname'] ?? null,
        'company' => $userData['company'] ?? null
      ],
      'tokens' => $tokens
    ];
  }
}
