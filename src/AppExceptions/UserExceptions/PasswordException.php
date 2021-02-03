<?php

declare(strict_types=1);

namespace Api\AppExceptions\UserExceptions;

use Api\AppExceptions\AppException;

class PasswordException extends AppException
{
  public function __construct(string $message)
  {
    parent::__construct($message, 400, 'INVALID_PASSWORD');
  }
}
