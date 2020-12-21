<?php

declare(strict_types=1);

namespace Api\Models;

use MongoDB\Collection;
use Api\Database\DatabaseConnector;
use MongoDB\BSON\ObjectId;
use MongoDB\DeleteResult;
use MongoDB\InsertOneResult;
use MongoDB\UpdateResult;

abstract class AbstractModel {
  private Collection $collection;

  protected function connectWithCollection($collectionName): void
  {
    $db = DatabaseConnector::connect();
    $this->collection = $db->selectCollection($collectionName);
  }

  protected function findOne($filter, $options = []): ?array
  {
    $result = (array) $this->collection->findOne($filter, $options);
    return $this->convertObjectIdOnString($result);
  }

  protected function findMany($filter, $options = []): array
  {
    $cursor = $this->collection->find($filter, $options);
    $result = [];

    foreach ($cursor as $project)
    {
      $projectArray = (array) $project;
      $projectArray = $this->convertObjectIdOnString($projectArray);
      array_push($result, $projectArray);
    }

    return $result;
  }

  protected function insertOne(array $data): InsertOneResult
  {
    return $this->collection->insertOne($data);
  }

  protected function updateOne(array $filter, array $update): UpdateResult
  {
    return $this->collection->updateOne($filter, $update);
  }

  protected function deleteOne(array $filter): DeleteResult
  {
    return $this->collection->deleteOne($filter);
  }

  protected function deleteMany(array $filter): DeleteResult
  {
    return $this->collection->deleteMany($filter);
  }

  protected function count(array $filter, array $options = []): int
  {
    return $this->collection->countDocuments($filter, $options);
  }

  protected function getIdFilter(string $id): array
  {
    return ['_id' => new ObjectId($id)];
  }

  protected function convertObjectIdOnString(array $item): array
  {
    if(isset($item['_id'])) {
      $item['id'] = $item['_id']->__toString(); // getting id as string from mongo object id.
      unset($item['_id']);
    }
    return $item;
  }
}
