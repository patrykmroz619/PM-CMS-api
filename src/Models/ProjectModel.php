<?php

declare(strict_types=1);

namespace Api\Models;

use MongoDB\Collection;
use MongoDB\InsertOneResult;
use MongoDB\Model\BSONDocument;
use MongoDB\UpdateResult;
use MongoDB\BSON\ObjectId;
use Api\Models\AbstractModel;
use MongoDB\DeleteResult;

class ProjectModel extends AbstractModel implements ModelInterface {
  private const PROJECTS_COLLECTION_NAME = "projects";

  public function insertOne(array $data): InsertOneResult
  {
    return $this->getProjectsCollection()->insertOne($data);
  }

  public function findOneByUidAndName(string $uid, string $name): array
  {
    return (array) $this->findOne(['userId' => $uid, 'name' => $name]);
  }

  public function findOneById(string $id): array
  {
    $result = (array) $this->findOne(['_id' => new ObjectId($id)]);
    return $this->convertObjectIdOnString($result);
  }

  public function findManyByUserId(string $uid): array
  {
    return $this->findMany(['userId' => $uid]);
  }

  public function updateById(string $id, array $data): array
  {
    return (array) $this->update(['_id' => new ObjectId($id)], $data);
  }

  public function deleteOne(string $id): DeleteResult
  {
    return $this->getProjectsCollection()->deleteOne(['_id' => new ObjectId($id)]);
  }

  public function findOne(array $filter): ?BSONDocument
  {
    return $this->getProjectsCollection()->findOne($filter);
  }

  public function findMany(array $filter, array $options = []): array
  {
    $cursor = $this->getProjectsCollection()->find($filter, $options);
    $result = [];

    foreach ($cursor as $project)
    {
      $projectArray = (array) $project;
      $projectArray = $this->convertObjectIdOnString($projectArray);
      array_push($result, $projectArray);
    }

    return $result;
  }

  public function update(array $filter, array $data): UpdateResult
  {
    return $this->getProjectsCollection()->updateOne($filter, ['$set' => $data]);
  }

  private function getProjectsCollection(): Collection
  {
    return $this->getCollection(self::PROJECTS_COLLECTION_NAME);
  }

  private function convertObjectIdOnString(array $item): array
  {
    $item['id'] = ((array)$item['_id'])['oid']; // getting id as string from mongo object id.
    unset($item['_id']);
    return $item;
  }
}
