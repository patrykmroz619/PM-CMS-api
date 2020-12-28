<?php

declare(strict_types=1);

namespace Api\AppExceptions\RecordExceptions;

class RecordNotFoundException extends RecordException
{
  public function __construct()
  {
    parent::__construct('Record was not found.', 'RECORD_NOT_FOUND');
  }
}
