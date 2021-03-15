<?php

declare(strict_types=1);

namespace Api\Services\Token;

use Psr\Http\Message\ServerRequestInterface as Request;
use Exception;
use Api\AppExceptions\AuthExceptions\JWTWasNotPassedException;
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

  protected static function validateToken(string $tokenAsString, array $config): ?array
  {
    try
    {
      JWT::$leeway = $config['leeway'] ?? 0;
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

  abstract static function validate(string $tokenAsString): ?array;
}
