<?php

declare(strict_types=1);

namespace Api\Models\User;

use Api\AppExceptions\SignInExceptions\UserNotFoundException;

class UserModel extends AbstractUserModel
{
  public function create(array $data): string
  {
    $result = $this->insertOne($data);
    return $result->getInsertedId()->__toString();
  }

  public function findById(string $id): array
  {
    $filter = $this->getIdFilter($id);
    return $this->findUser($filter);
  }

  public function findByEmail(string $email): array
  {
    return $this->findUser(['email' => $email]);
  }

  public function update(string $id, array $data): void
  {
    $filter = $this->getIdFilter($id);
    $this->updateOne($filter, ['$set' => $data]);
  }

  public function removeToken(string $id): void
  {
    $filter = $this->getIdFilter($id);
    $this->updateOne($filter, ['$unset' => ['refreshToken' => '']]);
  }

  public function delete(string $id): bool
  {
    $filter = $this->getIdFilter($id);
    $result = $this->deleteOne($filter);

    if($result->getDeletedCount() === 1)
      return true;

    return false;
  }

  public function isExistWithEmail(string $email): bool
  {
    $amount = $this->count(['email' => $email]);
    return $amount > 0;
  }
}
