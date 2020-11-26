<?php

declare (strict_types=1);

namespace AppExceptions\AuthExceptions;

use AppExceptions\AppException;

class AuthException extends AppException
{
  public function __construct(string $message)
  {
    $this->message = $message;
    $this->code = 401;
    $this->type = 'AUTH_ERROR';
  }
}
