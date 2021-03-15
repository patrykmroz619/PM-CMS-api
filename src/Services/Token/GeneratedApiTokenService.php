<?php

declare(strict_types=1);

namespace Api\Services\Token;

use Api\Settings\Settings;
use Firebase\JWT\JWT;

class GeneratedApiTokenService extends AbstractTokenService
{
  public static function validate(string $tokenAsString): ?array
  {
    $config = self::getConfig();
    return self::validateToken($tokenAsString, $config);
  }

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

  private static function getConfig(): array
  {
    $tokenConfig = Settings::getGeneratedApiTokenConfig();
    return [
      'jti' => $tokenConfig['jti'],
      'hmacKey' => $tokenConfig['hmacKey']
    ];
  }
}
