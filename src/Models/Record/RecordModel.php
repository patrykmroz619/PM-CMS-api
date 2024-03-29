<?php

declare(strict_types=1);

namespace Api\Models\Record;

use Api\AppExceptions\RecordExceptions\RecordNotFoundException;
use MongoDB\UpdateResult;

class RecordModel extends AbstractRecordModel
{
  public function add(array $data): string
  {
    $result = $this->insertOne($data);
    return $result->getInsertedId()->__toString();
  }

  public function getAll(string $contentModelId): array
  {
    $filter = ['contentModelId' => $contentModelId];

    return $this->findMany($filter);
  }

  public function findByNameValueAndContentModelId(string $name, $value, string $contentModelId): ?array
  {
    $filter = [
      'contentModelId' => $contentModelId,
      'data' => ['$elemMatch' => ['name' => $name, 'value' => $value]]
    ];

    return $this->findOne($filter);
  }

  public function findById(string $recordId): ?array
  {
    $filter = $this->getIdFilter($recordId);
    return $this->findOne($filter);
  }

  public function updateRecord(string $recordId, array $data): UpdateResult
  {
    $filter = $this->getIdFilter($recordId);
    return $this->updateOne($filter, ['$set' => ['data' => $data]]);
  }

  public function deleteByIdAndUserId(string $recordId, string $userId): void
  {
    $filter = $this->getIdFilter($recordId);
    $filter['userId'] = $userId;

    $result = $this->deleteOne($filter);

    if($result->getDeletedCount() == 0)
      throw new RecordNotFoundException();
  }

  public function deleteManyByContentModelId(string $contentModelId): void
  {
    $fitler = ['contentModelId' => $contentModelId];

    $this->deleteMany($fitler);
  }
}
