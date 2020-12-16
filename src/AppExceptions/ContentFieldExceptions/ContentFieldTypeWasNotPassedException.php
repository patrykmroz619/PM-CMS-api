<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentFieldExceptions;

class ContentFieldTypeWasNotPassedException extends ContentFieldException
{
  public function __construct()
  {
    parent::__construct('The type property of content field was not passed.');
  }
}
