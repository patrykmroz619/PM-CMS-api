<?php

declare (strict_types=1);

namespace Api\AppExceptions\AuthExceptions;

class InvalidActiveTokenException extends AuthException
{
  public function __construct()
  {
    parent::__construct('Active token is invalid or expired.', 'INVALID_ACTIVE_TOKEN');
  }
}
