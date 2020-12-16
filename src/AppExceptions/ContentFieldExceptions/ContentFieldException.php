<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentFieldExceptions;

use Api\AppExceptions\AppException;

class ContentFieldException extends AppException
{
  public function __construct(string $message)
  {
    $this->code = 400;
    $this->message = $message;
    $this->type = 'CONTENT_FIELD_ERROR';
  }
}
