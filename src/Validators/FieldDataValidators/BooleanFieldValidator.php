<?php

declare(strict_types=1);

namespace Api\Validators\FieldDataValidators;

use Api\Validators\ValidatorInterface;

class BooleanFieldValidator extends AbstractFieldDataValidator implements ValidatorInterface
{
  public function validate(array $data): array
  {
    $this->validateFieldType($data, 'boolean');
    $this->validateFieldName($data, 'boolean');

    $correctData = [
      'id' => $data['id'],
      'type' => $data['type'],
      'name' => $data['name']
    ];

    return $correctData;
  }
}
