<?php

declare(strict_types=1);

namespace Api\Services\ContentFields;

use Api\AppExceptions\RecordExceptions\InvalidRecordValueException;
use Api\Validators\FieldDataValidators\BooleanFieldValidator;

class BooleanField extends AbstractContentField
{
  public function __construct(array $data)
  {
    $validator = new BooleanFieldValidator();
    $this->fieldData = $validator->validate($data);
  }

  public function validateRecordItem(array $recordItem): array
  {
    $this->isValueBoolean($recordItem);

    return [
      'name' => $recordItem['name'],
      'value' => $recordItem['value']
    ];
  }

  private function isValueBoolean(array $recordItem): void
  {
    if(!is_bool($recordItem['value']))
      throw new InvalidRecordValueException($recordItem['name'], 'The value should be boolean.');
  }
}
