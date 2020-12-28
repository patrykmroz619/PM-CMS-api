<?php

declare(strict_types=1);

namespace Api\AppExceptions\RecordExceptions;

class RecordNotPassedException extends RecordException
{
  public function __construct()
  {
    parent::__construct('Record data was not passed.', 'RECORD_DATA_NOT_PASSED');
  }
}
