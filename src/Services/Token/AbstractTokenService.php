<?php

declare(strict_types=1);

namespace Api\Services\Token;

use Psr\Http\Message\ServerRequestInterface as Request;
use Api\AppExceptions\AuthExceptions\JWTWasNotPassedException;
use Api\Settings\Settings;
use Exception;
use Firebase\JWT\JWT;

abstract class AbstractTokenService
{
  public static function getTokenFromRequest(Request $request): string
  {
    $authHeader = $request->getHeader('Authorization');

    if(!isset($authHeader[0]))
      throw new JWTWasNotPassedException();

    $token = substr($authHeader[0], 7);
    return $token;
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

  protected static function getConfig(): array
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
