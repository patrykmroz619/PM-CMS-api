<?php

declare(strict_types=1);

namespace Api\AppExceptions\GeneratedApiExceptions;

use Api\AppExceptions\AppException;

class GeneratedApiException extends AppException
{
  public function __construct(string $message, string $type = 'RECORD_ERROR', int $code = 400)
  {
    $this->code = $code;
    $this->message = $message;
    $this->type = $type;
  }
}
