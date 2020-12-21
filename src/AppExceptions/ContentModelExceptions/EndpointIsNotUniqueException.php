<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentModelExceptions;

use Api\AppExceptions\ContentModelExceptions\ContentModelException;

class EndpointIsNotUniqueException extends ContentModelException
{
  public function __construct()
  {
    parent::__construct(
      'The content model\'s api endpoint is not unique.',
      'ENDPOINT_NOT_UNIQUE'
    );
  }
}
