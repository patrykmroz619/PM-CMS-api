<?php

declare(strict_types=1);

namespace Api\AppExceptions\RecordExceptions;

use Api\AppExceptions\AppException;

class RecordException extends AppException
{
  public function __construct(string $message, string $type = 'RECORD_ERROR')
  {
    $this->code = 400;
    $this->message = $message;
    $this->type = $type;
  }
}
