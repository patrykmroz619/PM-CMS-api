<?php

declare (strict_types=1);

namespace Api\AppExceptions\UserExceptions;

class InvalidCompanyNameException extends UserException
{
  public function __construct()
  {
    parent::__construct(
      'The company name is not valid.',
      'INVALID_COMPANY_NAME'
    );
  }
}
