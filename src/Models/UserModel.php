<?php

declare (strict_types=1);

namespace Api\Models;

use MongoDB\Collection;
use MongoDB\DeleteResult;
use MongoDB\InsertOneResult;
use MongoDB\Model\BSONDocument;
use MongoDB\UpdateResult;

class UserModel extends AbstractModel implements ModelInterface {
  private const USER_COLLECTION_NAME = "users";

  public function getUserById (string $uid): array
  {
    return (array) $this->findOne(['uid' => $uid]);
  }

  public function updateById(string $uid, array $updateData): UpdateResult
  {
    return $this->update(['uid' => $uid], $updateData);
  }

  public function delete(string $uid): DeleteResult
  {
    return $this->getUserCollection()->deleteOne(['uid' => $uid]);
  }

  public function insertOne(array $data): InsertOneResult
  {
    return $this->getUserCollection()->insertOne($data);
  }

  public function findOne(array $filter): ?BSONDocument
  {
    return $this->getUserCollection()->findOne($filter);
  }

  public function findMany(array $filter, array $options = []): array
  {
    return [];
  }

  public function update(array $filter, array $data): UpdateResult
  {
    return $this->getUserCollection()->updateOne($filter, ['$set' => $data]);
  }

  private function getUserCollection(): Collection
  {
    return $this->getCollection(self::USER_COLLECTION_NAME);
  }
}
