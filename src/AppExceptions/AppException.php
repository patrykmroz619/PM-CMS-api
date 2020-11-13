<?php

declare (strict_types=1);

namespace AppExceptions;

use Exception;
use Throwable;

class AppException extends Exception {
  protected string $type;

  public function __construct(string $message, int $statusCode)
  {
    $this->message = $message;
    $this->code = $statusCode;
    $this->type = 'APP_ERROR';
  }

  public function getType(): string
  {
    return $this->type;
  }
}
