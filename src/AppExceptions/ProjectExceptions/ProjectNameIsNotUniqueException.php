<?php

declare(strict_types=1);

namespace Api\AppExceptions\ProjectExceptions;

use Api\AppExceptions\AppException;

class ProjectNameIsNotUniqueException extends AppException
{
  public function __construct()
  {
    parent::__construct('Project with passed name is already exists.', 400, 'PROJECT_ERROR');
  }
}
