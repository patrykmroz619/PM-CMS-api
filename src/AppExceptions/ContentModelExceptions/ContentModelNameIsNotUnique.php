<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentModelExceptions;

class ContentModelNameIsNotUnique extends ContentModelException
{
  public function __construct()
  {
    parent::__construct('The content model\'s name is not unique.');
  }
}
