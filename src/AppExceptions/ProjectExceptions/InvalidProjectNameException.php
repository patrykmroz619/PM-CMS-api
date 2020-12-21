<?php

declare(strict_types=1);

namespace Api\AppExceptions\ProjectExceptions;

use Api\AppExceptions\AppException;

class InvalidProjectNameException extends AppException
{
  public function __construct()
  {
    parent::__construct(
      'The project name is not valid.',
      400,
      'INVALID_PROJECT_NAME'
    );
  }
}
