<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentFieldExceptions;

class ContentFieldNotFoundException extends ContentFieldException
{
  public function __construct()
  {
    parent::__construct(
      'The content field was not found.',
      'CONTENT_FIELD_NOT_FOUND',
      404
    );
  }
}
