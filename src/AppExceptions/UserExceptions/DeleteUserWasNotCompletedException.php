<?php

declare(strict_types=1);

namespace Api\AppExceptions\UserExceptions;

class DeleteUserWasNotCompletedException extends UserException
{
  public function __construct()
  {
    parent::__construct('Deleting user was not completed.', 'DELETE_ERROR');
  }
}
