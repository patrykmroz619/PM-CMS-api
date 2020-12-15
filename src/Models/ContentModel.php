<?php

declare(strict_types=1);

namespace Api\Models;

use Api\AppExceptions\ContentModelExceptions\ContentModelNotFound;
use Exception;
use MongoDB\BSON\ObjectId;
use MongoDB\Collection;
use MongoDB\DeleteResult;
use MongoDB\InsertOneResult;
use MongoDB\Model\BSONDocument;
use MongoDB\UpdateResult;

class ContentModel extends AbstractModel
{
  private const COLLECTION_NAME = "content models";

  public function findOneByProjectIdAndName(string $projectId, string $name): ?array
  {
    $result = $this->findOne(['projectId' => $projectId, 'name' => $name]);

    if($result) {
      return $this->convertObjectIdOnString((array) $result);
    }
    return null;
  }

  public function findOneById(string $id): ?array
  {
    $result = $this->findOne(['_id' => new ObjectId($id)]);

    if($result) {
      return $this->convertObjectIdOnString((array) $result);
    }
    return null;
  }

  public function findManyByProjectId(string $projectId): array
  {
    return $this->findMany(['projectId' => $projectId]);
  }

  public function insertOne(array $data): InsertOneResult
  {
    return $this->getContentModelCollection()->insertOne($data);
  }

  public function updateById(string $id, array $data): UpdateResult
  {
    $filter = ['_id' => new ObjectId($id)];
    try {
      return $this->getContentModelCollection()->updateOne($filter, ['$set' => $data]);
    } catch (Exception $e)
    {
      return null;
    }
  }

  public function deleteById(string $id): DeleteResult
  {
    return $this->getContentModelCollection()->deleteOne(['_id' => new ObjectId($id)]);
  }

  public function findMany(array $filter, array $options = []): array
  {
    $cursor = $this->getContentModelCollection()->find($filter, $options);
    $result = [];

    foreach ($cursor as $contentModel)
    {
      $contentModelArray = (array) $contentModel;
      $contentModelArray = $this->convertObjectIdOnString($contentModelArray);
      array_push($result, $contentModelArray);
    }

    return $result;
  }

  private function findOne(array $query): ?BSONDocument
  {
    return $this->getContentModelCollection()->findOne($query);
  }

  private function getContentModelCollection(): Collection
  {
    return $this->getCollection(self::COLLECTION_NAME);
  }
}
