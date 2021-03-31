<?php

declare(strict_types=1);

namespace Api\Services\ContentFields;

use Api\AppExceptions\RecordExceptions\InvalidRecordValueException;
use Api\Validators\FieldDataValidators\TextFieldValidator;

class TextField extends AbstractContentField
{
  public function __construct(array $data)
  {
    $validator = new TextFieldValidator();
    $this->fieldData = $validator->validate($data);
  }

  public function validateRecordItem(array $recordItem): array
  {
    $this->isValueString($recordItem);

    if(isset($this->fieldData['minLength']) && $this->fieldData['minLength'])
      $this->validateMinLength($recordItem);

    if(isset($this->fieldData['maxLength']) && $this->fieldData['maxLength'])
      $this->validateMaxLength($recordItem);

    return [
      'name' => $recordItem['name'],
      'value' => $recordItem['value']
    ];
  }

  private function isValueString(array $recordItem)
  {
    if(!is_string($recordItem['value']))
      throw new InvalidRecordValueException($recordItem['name'], 'type of value must be a string.');
  }

  private function validateMinLength(array $recordItem)
  {
    $minLength = $this->fieldData['minLength'];

    if(strlen($recordItem['value']) < $minLength)
      throw new InvalidRecordValueException($recordItem['name'], "length of value should be $minLength at least.");
  }

  private function validateMaxLength(array $recordItem)
  {
    $maxLength = $this->fieldData['maxLength'];

    if(strlen($recordItem['value']) > $maxLength)
      throw new InvalidRecordValueException($recordItem['name'], "length of value should be $maxLength at most.");
  }
}
