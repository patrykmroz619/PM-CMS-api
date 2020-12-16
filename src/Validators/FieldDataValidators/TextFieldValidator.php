<?php

declare(strict_types=1);

namespace Api\Validators\FieldDataValidators;

use Api\AppExceptions\ContentFieldExceptions\ContentFieldException;

class TextFieldValidator extends AbstractFieldDataValidator
{
  public function validate(array $data): array
  {
    $this->validateFieldType($data, 'text');
    $this->validateFieldName($data);
    $this->validateMinAndMaxLengthProperties($data);
    $this->validateBooleanProperty($data, 'multiline');
    $this->validateBooleanProperty($data, 'unique');

    $correctData = [
      'type' => $data['type'],
      'name' => $data['name'],
      'minLength' => $data['minLength'] ?? null,
      'maxLength' => $data['maxLength'] ?? null,
      'unique' => $data['unique'],
      'multiline' => $data['multiline']
    ];

    return $correctData;
  }

  private function validateMinAndMaxLengthProperties(array $data): void
  {
    if(isset($data['minLength'])) {
      if(is_int($data['minLength']))
        throw new ContentFieldException('The integer is an expected type of minLength property.');
    }

    if(isset($data['maxLength'])) {
      if(is_int($data['maxLength']))
        throw new ContentFieldException('The integer is an expected type of maxLength property.');
    }
  }
}
