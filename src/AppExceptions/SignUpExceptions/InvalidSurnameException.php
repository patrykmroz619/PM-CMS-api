<?php

declare (strict_types=1);

namespace AppExceptions\SignUpExceptions;

class InvalidSurnameException extends SignUpException
{
  public function __construct()
  {
    parent::__construct('Surname is not valid.');
  }
}