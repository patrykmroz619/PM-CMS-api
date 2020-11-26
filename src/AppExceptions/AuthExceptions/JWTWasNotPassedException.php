<?php

declare(strict_types=1);

namespace AppExceptions\AuthExceptions;

class JWTWasNotPassedException extends AuthException {
  public function __construct()
  {
    parent::__construct('Token was not passed in authorization header');
  }
}
