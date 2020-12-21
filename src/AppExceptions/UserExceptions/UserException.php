<?php

declare(strict_types=1);

namespace Api\AppExceptions\UserExceptions;

use Api\AppExceptions\AppException;

class UserException extends AppException {
  public function __construct(string $message, string $type = 'USER_ERROR')
  {
    $this->message = $message;
    $this->type = $type;
    $this->code = 400;
  }
}
