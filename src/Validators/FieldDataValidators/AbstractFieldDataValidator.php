<?php

declare(strict_types=1);

namespace Api\Validators\FieldDataValidators;

use Api\AppExceptions\ContentFieldExceptions\ContentFieldException;
use Api\AppExceptions\ContentFieldExceptions\ContentFieldTypeIsInvalidException;
use Api\AppExceptions\ContentFieldExceptions\ContentFieldTypeWasNotPassedException;

abstract class AbstractFieldDataValidator
{
  protected function validateFieldType(array $data, string $expected)
  {
    if(!isset($data['type']))
      throw new ContentFieldTypeWasNotPassedException();

    if($data['type'] != $expected)
      throw new ContentFieldTypeIsInvalidException();
  }

  protected function validateFieldName(array $data): void
  {
    if(!isset($data['name']))
      throw new ContentFieldException('The name property of the content field is required.');

    $nameLength = strlen($data['name']);
    if($nameLength > 35)
      throw new ContentFieldException('The name of content field can be maximum of 35 characters.');
  }

  protected function validateBooleanProperty(array $data, string $property): void
  {
    if(!isset($data[$property]))
      throw new ContentFieldException("The ${property} property of the content field is required.");

    if(!is_bool($data[$property]))
      throw new ContentFieldException("The boolean is an expected type of ${property} property.");
  }
}
