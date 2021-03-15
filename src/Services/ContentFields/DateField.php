<?php

namespace Api\Services\ContentFields;

use Api\AppExceptions\RecordExceptions\InvalidRecordValueException;
use Api\Validators\FieldDataValidators\DateFieldValidator;
use DateTime;

class DateField extends AbstractContentField
{
  public function __construct(array $data)
  {
    $validator = new DateFieldValidator();
    $this->fieldData = $validator->validate($data);
  }

  public function validateRecordItem(array $recordItem): array
  {
    $this->isValidDate($recordItem);

    return [
      'name' => $recordItem['name'],
      'value' => $recordItem['value']
    ];
  }

  private function isValidDate(array $recordItem): void
  {
    if(!$this->validateDate($recordItem['value']))
      throw new InvalidRecordValueException($recordItem['name'], 'The value is not valid date.');
  }

  private function validateDate(string $date): bool
  {
    $format = 'Y-m-d';
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
  }
}
