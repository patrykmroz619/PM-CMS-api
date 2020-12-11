<?php

declare(strict_types=1);

namespace Api\AppExceptions\ProjectExceptions;

use Api\AppExceptions\AppException;

class InvalidApiEndpointForProjectException extends AppException
{
  public function __construct()
  {
    parent::__construct('Api endpoint for the project is not correct.', 400, 'PROJECT_ERROR');
  }
}
