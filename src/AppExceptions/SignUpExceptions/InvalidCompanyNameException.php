<?php

declare (strict_types=1);

namespace Api\AppExceptions\SignUpExceptions;

class InvalidCompanyNameException extends SignUpException
{
  public function __construct()
  {
    parent::__construct('Company name is not valid.');
  }
}
