<?php

declare(strict_types=1);

namespace Api\Models;

use MongoDB\Collection;
use MongoDB\InsertOneResult;
use MongoDB\Model\BSONDocument;

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
  public function insertOne(array $data): InsertOneResult
  {
    return $this->getContentModelCollection()->insertOne($data);
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
