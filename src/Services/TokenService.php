<?php

declare(strict_types=1);

namespace Services;

use AppExceptions\AuthExceptions\JWTWasNotPassedException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Exception;
use \Firebase\JWT\JWT;
use Settings\Settings;

class TokenService {

  public static function getActiveToken(string $uid): string
  {
    return self::generateToken($uid, true);
  }

  public static function getRefreshToken(string $uid): string
  {
    return self::generateToken($uid, false);
  }

  public static function validateToken(string $tokenAsString): ?object
  {
    $config = self::getConfig();
    try
    {
      return JWT::decode($tokenAsString, $config['hmacKey'], array('HS256'));
    }
    catch (Exception $e)
    {
      return null;
    }
  }

  public static function getTokenFromRequest(Request $request): string
  {
    $authHeader = $request->getHeader('Authorization');

    if(!isset($authHeader[0]))
      throw new JWTWasNotPassedException();

    $token = substr($authHeader[0], 7);
    return $token;
  }

  private static function generateToken(string $uid, $active): string
  {
    $config = self::getConfig();

    $time = time();

    $payload = [
    "iss" => $config['api_url'],
    "aud" => $config['client_url'],
    "iat" => $time,
    "exp" => $time + ($active ? $config['access_exp'] : $config['refresh_exp']),
    'uid' => $uid,
    'active' => $active
    ];

    $jwt = JWT::encode($payload, $config['hmacKey']);

    return $jwt;
  }

  private static function getConfig(): array
  {
    $urls = Settings::getAppsUrl();
    $tokenConfig = Settings::getTokenConfig();
    return [
      'api_url' => $urls['api'],
      'client_url' => $urls['client'],
      'jti' => $tokenConfig['jti'],
      'access_exp' => $tokenConfig['access_exp'],
      'refresh_exp' => $tokenConfig['refresh_exp'],
      'hmacKey' => $tokenConfig['hmacKey']
    ];
  }
}
