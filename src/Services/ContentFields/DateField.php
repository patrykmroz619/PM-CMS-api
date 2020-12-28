<?php

namespace Api\Services\ContentFields;

use Api\AppExceptions\RecordExceptions\InvalidRecordValueException;
use Api\Validators\FieldDataValidators\DateFieldValidator;

class DateField extends AbstractContentField
{
  public function __construct(array $data)
  {
    $validator = new DateFieldValidator();
    $this->fieldData = $validator->validate($data);
  }

  public function validateRecordItem(array $recordItem): array
  {
    $this->isValueTimestamp($recordItem);

    return [
      'name' => $recordItem['name'],
      'value' => $recordItem['value']
    ];
  }

  private function isValueTimestamp(array $recordItem): void
  {
    if(!is_int($recordItem['value']))
      throw new InvalidRecordValueException($recordItem['name'], 'The value must be a timestamp.');
  }
}
