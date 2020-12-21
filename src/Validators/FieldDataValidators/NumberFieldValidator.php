<?php

declare(strict_types=1);

namespace Api\Validators\FieldDataValidators;

use Api\AppExceptions\ContentFieldExceptions\ContentFieldException;
use Api\AppExceptions\ContentFieldExceptions\InvalidContentFieldDataException;

class NumberFieldValidator extends AbstractFieldDataValidator
{
  public function validate(array $data): array
  {
    $this->validateFieldType($data, 'number');
    $this->validateFieldName($data, 'number');
    $this->validateBooleanProperty($data, 'integer', 'number');
    $this->validateMinAndMaxProperties($data);

    $correctData = [
      'id' => $data['id'],
      'type' => $data['type'],
      'name' => $data['name'],
      'integer' => $data['integer'],
      'min' => $data['min'] ?? null,
      'max' => $data['max'] ?? null
    ];

    return $correctData;
  }

  private function validateMinAndMaxProperties(array $data): void
  {
    if(isset($data['min'])) {
      if(!is_numeric($data['min']))
        throw new InvalidContentFieldDataException('The min property is not a number.', 'number');
    }

    if(isset($data['max'])) {
      if(!is_numeric($data['max']))
        throw new InvalidContentFieldDataException('The max property is not a number.', 'number');
    }
  }
}
