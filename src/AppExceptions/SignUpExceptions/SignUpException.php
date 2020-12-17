<?php

declare (strict_types=1);

namespace Api\AppExceptions\SignUpExceptions;

use Api\AppExceptions\AppException;

class SignUpException extends AppException {
  public function __construct(string $message, string $type, int $code = 401)
  {
    $this->message = $message;
    $this->type = $type;
    $this->code = $code;
  }
}
