<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentModelExceptions;

class ContentModelNotFoundException extends ContentModelException
{
  public function __construct()
  {
    parent::__construct('The content model was not found.');
  }
}
