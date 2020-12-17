<?php

declare (strict_types=1);

namespace Api\AppExceptions\SignInExceptions;

class PasswordInvalidException extends SignInException
{
  public function __construct()
  {
    parent::__construct('Password is invalid.', 'INVALID_PASSWORD');
  }
}
