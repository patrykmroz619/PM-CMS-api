<?php

declare (strict_types=1);

namespace AppExceptions\AuthExceptions;

class InvalidActiveTokenException extends AuthException
{
  public function __construct()
  {
    parent::__construct('Active token is invalid or expired.');
  }
}
