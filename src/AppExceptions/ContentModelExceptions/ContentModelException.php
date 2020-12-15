<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentModelExceptions;

use Api\AppExceptions\AppException;

class ContentModelException extends AppException
{
  public function __construct(string $message)
  {
    $this->code = 400;
    $this->message = $message;
    $this->type = 'CONTENT_MODEL_ERROR';
  }
}
