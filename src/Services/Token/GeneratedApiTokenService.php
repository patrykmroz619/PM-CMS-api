<?php

declare(strict_types=1);

namespace Api\Services\Token;

use Firebase\JWT\JWT;

class GeneratedApiTokenService extends AbstractTokenService
{
  public static function generateToken(string $projectId, string $userId): string
  {
    $config = self::getConfig();

    $payload = [
      "iat" => time(),
      'projectId' => $projectId,
      'userId' => $userId,
      'apiKey' => true
    ];

    $jwt = JWT::encode($payload, $config['hmacKey']);

    return $jwt;
  }
}
