<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentModelExceptions;

class ContentModelEndpointWasNotPassedException extends ContentModelException
{
  public function __construct()
  {
    parent::__construct(
      'The content model\'s api endpoint was not passed.',
      'ENDPOINT_NOT_PASSED'
    );
  }
}
