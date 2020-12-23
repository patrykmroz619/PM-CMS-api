<?php

declare(strict_types=1);

namespace Api\Validators\FieldDataValidators;

use Api\AppExceptions\ContentFieldExceptions\InvalidContentFieldDataException;
use Api\Validators\ValidatorInterface;

class DateFieldValidator extends AbstractFieldDataValidator implements ValidatorInterface
{
  public function validate(array $data): array
  {
    $this->validateFieldType($data, 'date');
    $this->validateFieldName($data, 'date');

    $correctData = [
      'id' => $data['id'],
      'type' => $data['type'],
      'name' => $data['name']
    ];

    return $correctData;
  }
}
