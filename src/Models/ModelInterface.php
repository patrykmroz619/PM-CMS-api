<?php

declare(strict_types=1);

namespace Models;

use MongoDB\InsertOneResult;
use MongoDB\Model\BSONDocument;
use MongoDB\UpdateResult;

interface ModelInterface
{
  public function insertOne(array $data): InsertOneResult;

  public function findOne(array $filter): ?BSONDocument;

  public function findMany(array $filter): ?array;

  public function update(array $filter, array $data): UpdateResult;
}
