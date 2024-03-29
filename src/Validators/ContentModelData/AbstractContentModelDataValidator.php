<?php

declare(strict_types=1);

namespace Api\Validators\ContentModelData;

use Api\AppExceptions\ContentModelExceptions\ContentModelEndpointWasNotPassedException;
use Api\AppExceptions\ContentModelExceptions\ContentModelNameWasNotPassedException;
use Api\AppExceptions\ContentModelExceptions\InvalidApiEndpointForContentModelException;
use Api\AppExceptions\ContentModelExceptions\InvalidContentModelNameLengthException;

abstract class AbstractContentModelDataValidator
{
  protected function validateName(array $data): bool
  {
    if(!isset($data['name'])) {
      throw new ContentModelNameWasNotPassedException();
    }

    if(strlen($data['name']) > 35 || strlen($data['name']) < 3) {
      throw new InvalidContentModelNameLengthException();
    }

    return true;
  }

  protected function validateEndpoint($data): bool
  {
    if(!isset($data['endpoint']))
      throw new ContentModelEndpointWasNotPassedException();

    $pattern = "/^[a-z0-9]+(?:-[a-z0-9]+)*$/";
    if(!preg_match($pattern, $data['endpoint']))
      throw new InvalidApiEndpointForContentModelException();

    return true;
  }
}
