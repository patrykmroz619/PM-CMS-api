<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentModelExceptions;

class InvalidContentModelNameLengthException extends ContentModelException
{
  public function __construct()
  {
    parent::__construct('The length of content model\'s name must be between 3 and 35 characters.');
  }
}
