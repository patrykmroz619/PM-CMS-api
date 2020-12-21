<?php

declare (strict_types=1);

namespace Api\AppExceptions\UserExceptions;

class InvalidSurnameException extends UserException
{
  public function __construct()
  {
    parent::__construct(
      'The surname is not valid.',
      'INVALID_SURNAME'
    );
  }
}
