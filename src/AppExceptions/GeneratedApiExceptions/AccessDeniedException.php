<?php

declare(strict_types=1);

namespace Api\AppExceptions\GeneratedApiExceptions;

class AccessDeniedException extends GeneratedApiException
{
  public function __construct()
  {
    parent::__construct('Access denied, api token is wrong.', 'ACCESS_DENIED', 401);
  }
}
