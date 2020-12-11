<?php

declare(strict_types=1);

namespace Api\AppExceptions\ProjectExceptions;

use Api\AppExceptions\AppException;

class ProjectNotFoundException extends AppException
{
  public function __construct()
  {
    parent::__construct('The Project with the passed id was not found.', 400, 'PROJECT_ERROR');
  }
}
