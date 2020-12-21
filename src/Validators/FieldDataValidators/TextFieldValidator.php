<?php

declare(strict_types=1);

namespace Api\Validators\FieldDataValidators;

use Api\AppExceptions\ContentFieldExceptions\InvalidContentFieldDataException;

class TextFieldValidator extends AbstractFieldDataValidator
{
  public function validate(array $data): array
  {
    $this->validateFieldType($data, 'text');
    $this->validateFieldName($data, 'text');
    $this->validateMinAndMaxLengthProperties($data);
    $this->validateBooleanProperty($data, 'multiline', 'text');
    $this->validateBooleanProperty($data, 'unique', 'text');

    $correctData = [
      'id' => $data['id'],
      'type' => $data['type'],
      'name' => $data['name'],
      'multiline' => $data['multiline'],
      'unique' => $data['unique'],
      'minLength' => $data['minLength'] ?? null,
      'maxLength' => $data['maxLength'] ?? null
    ];

    return $correctData;
  }

  private function validateMinAndMaxLengthProperties(array $data): void
  {
    if(isset($data['minLength'])) {
      if(!is_int($data['minLength']))
        throw new InvalidContentFieldDataException('The integer is an expected type of minLength property.', 'text');
    }

    if(isset($data['maxLength'])) {
      if(!is_int($data['maxLength']))
        throw new InvalidContentFieldDataException('The integer is an expected type of maxLength property.', 'text');
    }
  }
}
