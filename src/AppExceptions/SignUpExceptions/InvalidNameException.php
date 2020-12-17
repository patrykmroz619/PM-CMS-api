<?php

declare (strict_types=1);

namespace Api\AppExceptions\SignUpExceptions;

class InvalidNameException extends SignUpException
{
  public function __construct()
  {
    parent::__construct(
      'The name is not valid.',
      'INVALID_NAME'
    );
  }
}
