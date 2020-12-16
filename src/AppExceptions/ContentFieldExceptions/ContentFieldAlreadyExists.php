<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentFieldExceptions;

class ContentFieldAlreadyExists extends ContentFieldException
{
  public function __construct()
  {
    parent::__construct('The content field with passed name already exists.');
  }
}
