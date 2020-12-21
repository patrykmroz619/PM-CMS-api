<?php

declare (strict_types=1);

namespace Api\AppExceptions\UserExceptions;

class InvalidNameException extends UserException
{
  public function __construct()
  {
    parent::__construct(
      'The name is not valid.',
      'INVALID_NAME'
    );
  }
}
