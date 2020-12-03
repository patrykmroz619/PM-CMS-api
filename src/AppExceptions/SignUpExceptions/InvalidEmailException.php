<?php

declare (strict_types=1);

namespace Api\AppExceptions\SignUpExceptions;

class InvalidEmailException extends SignUpException
{
  public function __construct()
  {
    parent::__construct('Email is not valid.');
  }
}
