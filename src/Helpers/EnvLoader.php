<?php

declare(strict_types=1);

namespace Helpers;

use Dotenv\Dotenv;

class EnvLoader {

  public static function load()
  {
    $env = Dotenv::createImmutable(__DIR__ . '/../../');

    $env->load();
  }
}
