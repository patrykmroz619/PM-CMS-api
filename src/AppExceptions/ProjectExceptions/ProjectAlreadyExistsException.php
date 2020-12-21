<?php

declare(strict_types=1);

namespace Api\AppExceptions\ProjectExceptions;

use Api\AppExceptions\AppException;

class ProjectAlreadyExistsException extends AppException
{
  public function __construct()
  {
    parent::__construct('A project already exists.', 400, 'PROJECT_EXISTS');
  }
}
