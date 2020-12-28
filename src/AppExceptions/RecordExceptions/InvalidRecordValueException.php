<?php

declare(strict_types=1);

namespace Api\AppExceptions\RecordExceptions;

class InvalidRecordValueException extends RecordException
{
  public function __construct(string $recordItemName, string $reason)
  {
    parent::__construct("Invalid value of ${recordItemName}: ${reason}");
  }
}
