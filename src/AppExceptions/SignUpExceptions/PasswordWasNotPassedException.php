<?php

declare (strict_types=1);

namespace Api\AppExceptions\SignUpExceptions;

class PasswordWasNotPassedException extends SignUpException
{
  public function __construct()
  {
    parent::__construct(
      'The password was not passed.',
      'PASSWORD_NOT_PASSED',
      400
    );
  }
}
