<?php

declare(strict_types=1);

namespace Api\AppExceptions\ProjectExceptions;

use Api\AppExceptions\AppException;

class EndpointIsNotUniqueException extends AppException
{
  public function __construct()
  {
    parent::__construct('The api endpoint must be unique.', 400, 'PROJECT_ERROR');
  }
}
