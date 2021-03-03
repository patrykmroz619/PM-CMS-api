<?php

declare(strict_types=1);

namespace Api\Services\Auth;

use Api\Services\Token\AuthTokenToPanelService;

abstract class AbstractAuthService
{
  protected function getTokens(string $userId): array
  {
    $accessToken = AuthTokenToPanelService::getAccessToken($userId);
    $refreshToken = AuthTokenToPanelService::getRefreshToken($userId);

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
