<?php

declare (strict_types=1);

namespace Api\AppExceptions\SignInExceptions;

use Api\AppExceptions\AppException;

class SignInException extends AppException
{
  public function __construct(string $message)
  {
    $this->message = $message;
    $this->code = 401;
    $this->type = 'SIGN_IN_ERROR';
  }
}
