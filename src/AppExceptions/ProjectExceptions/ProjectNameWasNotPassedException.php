<?php

declare(strict_types=1);

namespace Api\AppExceptions\ProjectExceptions;

use Api\AppExceptions\AppException;

class ProjectNameWasNotPassedException extends AppException
{
  public function __construct()
  {
    parent::__construct('Project name was not passed.', 400, 'PROJECT_ERROR');
  }
}
