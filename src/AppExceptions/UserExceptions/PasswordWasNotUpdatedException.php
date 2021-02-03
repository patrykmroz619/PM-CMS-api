<?php

declare (strict_types=1);

namespace Api\AppExceptions\UserExceptions;

class PasswordWasNotUpdatedException extends UserException
{
  public function __construct()
  {
    parent::__construct(
      'The passed password was not updated.',
      'PASSWORD_WAS_NOT_UPDATED'
    );
  }
}
