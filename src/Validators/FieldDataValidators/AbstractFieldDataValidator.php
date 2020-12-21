<?php

declare(strict_types=1);

namespace Api\Validators\FieldDataValidators;

use Api\AppExceptions\ContentFieldExceptions\ContentFieldException;
use Api\AppExceptions\ContentFieldExceptions\ContentFieldTypeIsInvalidException;
use Api\AppExceptions\ContentFieldExceptions\ContentFieldTypeWasNotPassedException;
use Api\AppExceptions\ContentFieldExceptions\InvalidContentFieldDataException;

abstract class AbstractFieldDataValidator
{
  protected function validateFieldType(array $data, string $expected)
  {
    if(!isset($data['type']))
      throw new ContentFieldTypeWasNotPassedException();

    if($data['type'] != $expected)
      throw new ContentFieldTypeIsInvalidException();
  }

  protected function validateFieldName(array $data, string $fieldType): void
  {
    if(!isset($data['name']))
      throw new InvalidContentFieldDataException('The name property of the content field is required.', $fieldType);

    $nameLength = strlen($data['name']);
    if($nameLength > 35)
      throw new InvalidContentFieldDataException('The name of content field can be maximum of 35 characters.', $fieldType);
  }

  protected function validateBooleanProperty(array $data, string $property, string $fieldType): void
  {
    if(!isset($data[$property]))
      throw new InvalidContentFieldDataException("The ${property} property of the content field is required.", $fieldType);

    if(!is_bool($data[$property]))
      throw new InvalidContentFieldDataException("The boolean is an expected type of the ${property} property.", $fieldType);
  }
}
