<?php

declare (strict_types=1);

namespace Api\AppExceptions\UserExceptions;

class InvalidCurrentPasswordException extends UserException
{
  public function __construct()
  {
    parent::__construct(
      'The passed current password is invalid.',
      'INVALID_CURRENT_PASSWORD'
    );
  }
}
