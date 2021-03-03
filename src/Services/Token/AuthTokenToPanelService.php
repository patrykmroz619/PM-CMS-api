<?php

declare(strict_types=1);

namespace Api\Services\Token;

use Firebase\JWT\JWT;

class AuthTokenToPanelService extends AbstractTokenService
{
  public static function getAccessToken(string $uid): string
  {
    return self::generateToken($uid, true);
  }

  public static function getRefreshToken(string $uid): string
  {
    return self::generateToken($uid, false);
  }

  private static function generateToken(string $uid, $access): string
  {
    $config = self::getConfig();

    $time = time();

    $payload = [
    "iss" => $config['api_url'],
    "aud" => $config['client_url'],
    "iat" => $time,
    "exp" => $time + ($access ? $config['access_exp'] : $config['refresh_exp']),
    'uid' => $uid,
    'access' => $access
    ];

    $jwt = JWT::encode($payload, $config['hmacKey']);

    return $jwt;
  }

}
