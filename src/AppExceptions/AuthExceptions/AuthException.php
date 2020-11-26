<?php

declare (strict_types=1);

namespace AppExceptions\AuthExceptions;

use AppExceptions\AppException;

class AuthException extends AppException
{
  public function __construct(string $message, string $type = 'AUTH_ERROR')
  {
    $this->message = $message;
    $this->code = 401;
    $this->type = $type;
  }
}
