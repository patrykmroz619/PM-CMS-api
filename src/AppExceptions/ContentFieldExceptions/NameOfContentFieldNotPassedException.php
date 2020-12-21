<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentFieldExceptions;

class NameOfContentFieldNotPassedException extends ContentFieldException
{
  public function __construct()
  {
    parent::__construct(
      'The name of content fields was not passed',
      'NAME_NOT_PASSED'
    );
  }
}
