<?php

declare(strict_types=1);

namespace Api\Settings;

final class Settings {
  public static function getDbConfig() : array
  {
    return [
      'host' => $_ENV['DB_HOST'],
      'name' => $_ENV['DB_NAME']
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
      'api' => $_ENV['API_URL'],
      'client' => $_ENV['CLIENT_URL']
    ];
  }

  public static function getTokenConfig() : array
  {
    return [
      'jti' => $_ENV['JWT_JTI_CLAIM'],
      'access_exp' => 60,
      'refresh_exp' => 3600,
      'leeway' => 5,
      'hmacKey' => $_ENV['JWT_HMAC_KEY']
    ];
  }
}
