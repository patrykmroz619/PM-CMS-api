<?php

declare(strict_types=1);

namespace Api\Models\User;

use Api\AppExceptions\SignInExceptions\UserNotFoundException;
use Api\Models\AbstractModel;

abstract class AbstractUserModel extends AbstractModel
{
  public function __construct()
  {
    $this->connectWithCollection('users');
  }

  protected function findUser(array $filter): array
  {
    $result = $this->findOne($filter);

    if(!$result)
      throw new UserNotFoundException();

    return $result;
  }
}
