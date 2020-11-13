<?php

declare (strict_types=1);

namespace AppExceptions\SignUpExceptions;

use AppExceptions\AppException;

class SignUpException extends AppException {
  public function __construct(string $message)
  {
    $this->message = $message;
    $this->type = 'SIGN_UP_ERROR';
    $this->code = 401;
  }
}
