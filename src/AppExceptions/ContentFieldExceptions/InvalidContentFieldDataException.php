<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentFieldExceptions;

class InvalidContentFieldDataException extends ContentFieldException
{
  public function __construct(string $message, string $fieldType)
  {
    $upperType = strtoupper($fieldType);
    parent::__construct($message, "INVALID_${upperType}_FIELD_DATA");
  }
}
