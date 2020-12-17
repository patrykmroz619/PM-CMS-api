<?php

declare (strict_types=1);

namespace Api\AppExceptions\SignUpExceptions;

class UserAlreadyExistsException extends SignUpException
{
  public function __construct()
  {
    parent::__construct(
      'An user with passed email address already exists.',
      'USER_EXISTS'
    );
  }
}
