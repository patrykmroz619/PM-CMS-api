<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentFieldExceptions;

class IdOfContentFieldNotPassedException extends ContentFieldException
{
  public function __construct()
  {
    parent::__construct(
      'Id of content field was not passed',
      'ID_NOT_PASSED'
    );
  }
}
