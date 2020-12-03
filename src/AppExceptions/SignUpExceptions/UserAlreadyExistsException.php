<?php

declare (strict_types=1);

namespace Api\AppExceptions\SignUpExceptions;

class UserAlreadyExistsException extends SignUpException
{
  public function __construct()
  {
    parent::__construct('An user already exists.');
  }
}
