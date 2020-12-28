<?php

declare(strict_types=1);

namespace Api\AppExceptions\RecordExceptions;

class InvalidRecordException extends RecordException
{
  public function __construct()
  {
    parent::__construct('Invalid record\'s data', 'INVALID_RECORD_DATA');
  }
}
