<?php

declare (strict_types=1);

namespace Api\AppExceptions\AuthExceptions;

class InvalidRefreshTokenException extends AuthException
{
  public function __construct()
  {
    parent::__construct('The refresh token is invalid or expired.', 'INVALID_REFRESH_TOKEN');
  }
}
