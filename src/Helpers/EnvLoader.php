<?php

declare(strict_types=1);

namespace Api\Helpers;

use Dotenv\Dotenv;
use Exception;

class EnvLoader {

  public static function load()
  {
    try {

      $env = Dotenv::createUnsafeImmutable(__DIR__ . '/../../');

      $env->load();
    } catch (Exception $e) {}
  }
}
