<?php

declare(strict_types=1);

namespace Api\Validators\FieldDataValidators;

use Api\AppExceptions\ContentFieldExceptions\InvalidContentFieldDataException;
use Api\Validators\ValidatorInterface;

class ColorFieldValidator extends AbstractFieldDataValidator implements ValidatorInterface
{
  public function validate(array $data): array
  {
    $this->validateFieldType($data, 'color');
    $this->validateFieldName($data, 'color');

    $correctData = [
      'id' => $data['id'],
      'type' => $data['type'],
      'name' => $data['name']
    ];

    return $correctData;
  }
}
