<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentFieldExceptions;

use Api\AppExceptions\AppException;

class ContentFieldException extends AppException
{
  public function __construct(string $message, string $type = 'CONTENT_FIELD_ERROR', $code = 400)
  {
    $this->code = $code;
    $this->message = $message;
    $this->type = $type;
  }
}
