<?php

declare(strict_types=1);

namespace Api\AppExceptions\UserExceptions;

class DataToUpdateWasNotPassedException extends UserException
{
  public function __construct()
  {
    parent::__construct('Data to update was not passed nor contain any fields to update.');
  }
}
