<?php

declare(strict_types=1);

namespace Api\Services\Token;

use Firebase\JWT\JWT;

class PublicApiTokenService extends AbstractTokenService
{
  public static function generateToken(string $projectId, string $userId): string
  {
    $config = self::getConfig();

    $payload = [
      "iat" => time(),
      'projectId' => $projectId,
      'userId' => $userId
    ];

    $jwt = JWT::encode($payload, $config['hmacKey']);

    return $jwt;
  }
}
