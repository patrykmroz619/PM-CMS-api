<?php

declare (strict_types=1);

namespace Api\AppExceptions\UserExceptions;

class InvalidEmailException extends UserException
{
  public function __construct()
  {
    parent::__construct(
      'The email address is not valid.',
      'INVALID_EMAIL',
    );
  }
}
