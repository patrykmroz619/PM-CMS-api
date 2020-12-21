<?php

declare(strict_types=1);

namespace Api\Services;

use Psr\Http\Message\ServerRequestInterface as Request;
use Exception;
use Firebase\JWT\JWT;
use Api\AppExceptions\AuthExceptions\JWTWasNotPassedException;
use Api\Settings\Settings;

class TokenService {
  public static function getAccessToken(string $uid): string
  {
    return self::generateToken($uid, true);
  }

  public static function getRefreshToken(string $uid): string
  {
    return self::generateToken($uid, false);
  }

  public static function validateToken(string $tokenAsString): ?array
  {
    $config = self::getConfig();
    try
    {
      JWT::$leeway = $config['leeway'];
      $token = (array) JWT::decode($tokenAsString, $config['hmacKey'], array('HS256'));

      if(empty($token))
        return null;

      return $token;
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
      'leeway' => $tokenConfig['leeway'],
      'hmacKey' => $tokenConfig['hmacKey']
    ];
  }
}
