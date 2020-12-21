<?php

declare(strict_types=1);

namespace Api\AppExceptions\ProjectExceptions;

use Api\AppExceptions\AppException;

class PublishedPropertyHasNotValueOfBooleanTypeException extends AppException
{
  public function __construct()
  {
    parent::__construct(
      'The published property has not a value of boolean type.',
      400,
      'INVALID_PUBLISHED_VALUE'
    );
  }
}
