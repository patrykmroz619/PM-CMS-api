<?php

declare(strict_types=1);

namespace Api\Models\Project;

use Api\AppExceptions\ProjectExceptions\ProjectNotFoundException;
use MongoDB\DeleteResult;
use MongoDB\UpdateResult;

class ProjectModel extends AbstractProjectModel
{
  public function create(array $data): string
  {
    $result = $this->insertOne($data);
    return $result->getInsertedId()->__toString();
  }

  public function findById(string $id): array
  {
    $filter = $this->getIdFilter($id);
    $result = $this->findOne($filter);
    if(!$result) {
      throw new ProjectNotFoundException();
    }
    return $result;
  }

  public function findByUserIdAndProjectName(string $userId, string $projectName): ?array
  {
    $filter = ['userId' => $userId, 'name' => $projectName];
    return $this->findOne($filter);
  }

  public function findByUserId(string $userId): array
  {
    return $this->findMany(['userId' => $userId]);
  }

  public function updateById(string $id, array $data): UpdateResult
  {
    $filter = $this->getIdFilter($id);
    return $this->updateOne($filter, ['$set' => $data]);
  }

  public function deleteByIdAndUserId(string $id, string $userId): bool
  {
    $filter = $this->getIdFilter($id);
    $filter['userId'] = $userId;

    $result = $this->deleteOne($filter);

    if($result->getDeletedCount() != 1)
      throw new ProjectNotFoundException();

    return true;
  }

  public function deleteManyByUserId(string $uid): DeleteResult
  {
    return $this->deleteMany(['userId' => $uid]);
  }
}
