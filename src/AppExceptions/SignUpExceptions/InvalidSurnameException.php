<?php

declare (strict_types=1);

namespace Api\AppExceptions\SignUpExceptions;

class InvalidSurnameException extends SignUpException
{
  public function __construct()
  {
    parent::__construct(
      'The surname is not valid.',
      'INVALID_SURNAME'
    );
  }
}
