<?php

declare (strict_types=1);

namespace Api\AppExceptions\SignInExceptions;

class UserNotFoundException extends SignInException
{
  public function __construct()
  {
    parent::__construct('User not found.', 'USER_NOT_FOUND');
  }
}
