<?php

declare(strict_types=1);

namespace Api\AppExceptions\ProjectExceptions;

use Api\AppExceptions\AppException;

class ProjectNotFoundException extends AppException
{
  public function __construct()
  {
    parent::__construct('The Project was not found.', 400, 'PROJECT_NOT_FOUND');
  }
}
