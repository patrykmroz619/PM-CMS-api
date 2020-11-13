<?php

declare(strict_types=1);

namespace Database;

use Exception;
use MongoDB\Client;
use Settings\Settings;

class DatabaseConnector {
  public static function connect() {

  $settings = Settings::getDbConfig();

  try {
    $connection = new Client($settings['host']);

    $db = $connection->selectDatabase($settings['name']);
  }
  catch(Exception $e) {
    throw new Exception($e);
  }

  return $db;
  }
}
