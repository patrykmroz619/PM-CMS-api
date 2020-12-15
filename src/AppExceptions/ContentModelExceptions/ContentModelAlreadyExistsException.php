<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentModelExceptions;

class ContentModelAlreadyExistsException extends ContentModelException
{
  public function __construct()
  {
    parent::__construct('The content model with passed name is already exists.');
  }
}
