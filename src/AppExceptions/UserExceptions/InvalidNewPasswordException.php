<?php

declare (strict_types=1);

namespace Api\AppExceptions\UserExceptions;

class InvalidNewPasswordException extends UserException
{
  public function __construct()
  {
    parent::__construct(
      'The passed new password is invalid.',
      'INVALID_NEW_PASSWORD'
    );
  }
}
