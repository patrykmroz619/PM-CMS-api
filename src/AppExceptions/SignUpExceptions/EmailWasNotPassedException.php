<?php

declare (strict_types=1);

namespace Api\AppExceptions\SignUpExceptions;

class EmailWasNotPassedException extends SignUpException
{
  public function __construct()
  {
    parent::__construct(
      'The email address was not passed.',
      'EMAIL_NOT_PASSED',
      400
    );
  }
}
