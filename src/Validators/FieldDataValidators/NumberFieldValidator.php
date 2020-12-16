<?php

declare(strict_types=1);

namespace Api\Validators\FieldDataValidators;

use Api\AppExceptions\ContentFieldExceptions\ContentFieldException;

class NumberFieldValidator extends AbstractFieldDataValidator
{
  public function validate(array $data): array
  {
    $this->validateFieldType($data, 'number');
    $this->validateFieldName($data);
    $this->validateBooleanProperty($data, 'isInteger');
    $this->validateMinAndMaxProperties($data);

    $correctData = [
      'type' => $data['type'],
      'name' => $data['name'],
      'isInteger' => $data['isInteger'],
      'min' => $data['min'] ?? null,
      'max' => $data['max'] ?? null
    ];

    return $correctData;
  }

  private function validateMinAndMaxProperties(array $data): void
  {
    if(isset($data['min'])) {
      if(is_numeric($data['min']))
        throw new ContentFieldException('The min property is not a number.');
    }

    if(isset($data['max'])) {
      if(is_numeric($data['max']))
        throw new ContentFieldException('The max property is not a number.');
    }
  }
}
