<?php

declare (strict_types=1);

namespace AppExceptions\SignUpExceptions;

class EmailWasNotPassedException extends SignUpException
{
  public function __construct()
  {
    parent::__construct('You haven\'t passed the email.');
  }
}
