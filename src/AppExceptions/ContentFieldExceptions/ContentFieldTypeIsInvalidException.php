<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentFieldExceptions;

class ContentFieldTypeIsInvalidException extends ContentFieldException
{
  public function __construct()
  {
    parent::__construct(
      'The type property of the content field is invalid.',
      'INVALID_FIELD_TYPE'
    );
  }
}
