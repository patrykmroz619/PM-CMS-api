<?php

declare(strict_types=1);

namespace Api\Models\Content;

use Api\AppExceptions\ContentModelExceptions\ContentModelNotFoundException;
use MongoDB\UpdateResult;

class ContentModel extends AbstractContentModel
{
  public function findByProjectId(string $projectId): array
  {
    return $this->findMany(['projectId' => $projectId]);
  }

  public function findByProjectIdAndUserId(string $projectId, string $userId): array
  {
    return $this->findMany(['projectId' => $projectId, 'userId' => $userId]);
  }

  public function findByProjectIdAndName(string $projectId, string $name): array
  {
    return $this->findOne(['projectId' => $projectId, 'name' => $name]);
  }

  public function findByProjectIdAndEndpoint(string $projectId, string $endpoint): array
  {
    return $this->findOne(['projectId' => $projectId, 'endpoint' => $endpoint]);
  }

  public function findByIdAndUserId(string $contentModelId, string $userId): array
  {
    $filter = $this->getIdFilter($contentModelId);
    $filter['userId'] = $userId;
    $result = $this->findOne($filter);

    if(empty($result))
      throw new ContentModelNotFoundException();

    return $result;
  }

  public function create(array $data): string
  {
    $result = $this->insertOne($data);
    return $result->getInsertedId()->__toString();
  }

  public function updateByIdAndUserId(string $contentModelId, string $userId, array $data): UpdateResult
  {
    $filter = $this->getIdFilter($contentModelId);
    $filter['userId'] = $userId;
    return $this->updateOne($filter, ['$set' => $data]);
  }

  public function deleteByIdAndUserId(string $contentModelId, string $userId): bool
  {
    $filter = $this->getIdFilter($contentModelId);
    $filter['userId'] = $userId;

    $result = $this->deleteOne($filter);

    if($result->getDeletedCount() != 1)
      throw new ContentModelNotFoundException();

    return true;
  }
}
