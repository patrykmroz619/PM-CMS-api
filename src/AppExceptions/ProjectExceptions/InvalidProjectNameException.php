<?php

declare(strict_types=1);

namespace Api\AppExceptions\ProjectExceptions;

use Api\AppExceptions\AppException;

class InvalidProjectNameException extends AppException
{
  public function __construct()
  {
    parent::__construct('Project name is not correct', 400, 'PROJECT_ERROR');
  }
}
