<?php

declare(strict_types=1);

namespace Api\AppExceptions\ContentModelExceptions;

class InvalidApiEndpointForContentModelException extends ContentModelException
{
  public function __construct()
  {
    parent::__construct('Invalid api endpoint for the content model.');
  }
}
