<?php

declare(strict_types=1);

namespace Api\Services\ContentFields;

use Api\AppExceptions\RecordExceptions\InvalidRecordValueException;
use Api\Validators\FieldDataValidators\NumberFieldValidator;

class NumberField extends AbstractContentField
{
  public function __construct(array $data)
  {
    $validator = new NumberFieldValidator();
    $this->fieldData = $validator->validate($data);
  }

  public function validateRecordItem(array $recordItem): array
  {
    $this->isValueNumber($recordItem);

    if(isset($this->fieldData['min']) && $this->fieldData['min'])
      $this->validateMinValue($recordItem);

    if(isset($this->fieldData['max']) && $this->fieldData['max'])
      $this->validateMaxValue($recordItem);

    if(isset($this->fieldData['integer']) && $this->fieldData['integer'])
      $this->validateIsInteger($recordItem);

    return [
      'name' => $recordItem['name'],
      'value' => $recordItem['value']
    ];
  }

  private function isValueNumber(array $recordItem)
  {
    if(!is_numeric($recordItem['value']))
      throw new InvalidRecordValueException($recordItem['name'], 'type of value must be a number.');
  }

  private function validateMinValue(array $recordItem)
  {
    $minValue = $this->fieldData['min'];

    if($recordItem['value'] < $minValue)
      throw new InvalidRecordValueException($recordItem['name'], "The value should be $minValue at least.");
  }

  private function validateMaxValue(array $recordItem)
  {
    $maxValue = $this->fieldData['max'];

    if($recordItem['value'] > $maxValue)
      throw new InvalidRecordValueException($recordItem['name'], "The value should be $maxValue at most.");
  }

  private function validateIsInteger(array $recordItem)
  {
    if(!is_int($recordItem['value']))
      throw new InvalidRecordValueException($recordItem['name'], 'The value should be integer');
  }
}
