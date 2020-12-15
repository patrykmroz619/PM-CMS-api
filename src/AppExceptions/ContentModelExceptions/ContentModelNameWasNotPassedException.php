<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentModelExceptions;

class ContentModelNameWasNotPassedException extends ContentModelException
{
  public function __construct()
  {
    parent::__construct('The content model\'s name was not passed.');
  }
}
