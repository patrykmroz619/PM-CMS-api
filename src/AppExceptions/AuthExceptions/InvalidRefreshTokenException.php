<?php

declare (strict_types=1);

namespace Api\AppExceptions\AuthExceptions;

class InvalidRefreshTokenException extends AuthException
{
  public function __construct()
  {
    parent::__construct('Refresh token is invalid or expired.');
  }
}
