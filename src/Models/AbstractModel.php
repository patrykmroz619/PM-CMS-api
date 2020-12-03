<?php

declare(strict_types=1);

namespace Api\Models;

use MongoDB\Collection;
use MongoDB\Database;
use Api\Database\DatabaseConnector;

abstract class AbstractModel {
  private Database $db;
  private Collection $collection;

  public function __construct()
  {
    $this->db = $this->createConnection();
  }

  private function createConnection() : Database
  {
    return DatabaseConnector::connect();
  }

  protected function getCollection(string $collectionName)
  {
    $collection = $this->db->selectCollection($collectionName);
    return $collection;
  }
}
