<?php

declare (strict_types=1);

namespace Api\AppExceptions\AuthExceptions;

class InvalidAccessTokenException extends AuthException
{
  public function __construct()
  {
    parent::__construct('The access token is invalid or expired.', 'INVALID_ACCESS_TOKEN');
  }
}
