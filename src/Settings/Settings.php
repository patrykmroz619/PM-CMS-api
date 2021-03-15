<?php

declare(strict_types=1);

namespace Api\Settings;

final class Settings {
  public static function getDbConfig() : array
  {
    return [
      'host' => getenv('DB_HOST'),
      'name' => getenv('DB_NAME')
    ];
  }

  public static function getErrorMiddlewareConfig () : array
  {
    return [
      'displayErrorDetails' => true,
      'logErrors' => true,
      'logErrorDetails' => true,
    ];
  }

  public static function getAppsUrl() : array
  {
    return [
      'api' => getenv('API_URL'),
      'client' => getenv('CLIENT_URL')
    ];
  }

  public static function getAuthTokenConfig() : array
  {
    return [
      'jti' => getenv('JWT_JTI_CLAIM_AUTH_TOKEN'),
      'access_exp' => getenv('ACCESS_TOKEN_EXP'),
      'refresh_exp' => getenv('REFRESH_TOKEN_EXP'),
      'leeway' => 5,
      'hmacKey' => getenv('JWT_HMAC_KEY_AUTH_TOKEN')
    ];
  }

  public static function getGeneratedApiTokenConfig() : array
  {
    return [
      'jti' => getenv('JWT_JTI_CLAIM_GENERATED_API_TOKEN'),
      'hmacKey' => getenv('JWT_HMAC_KEY_GENERATED_API_TOKEN')
    ];
  }
}
