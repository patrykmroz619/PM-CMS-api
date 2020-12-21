<?php

declare(strict_types=1);

namespace Api\Validators\UserData;

use Api\AppExceptions\UserExceptions\DataToUpdateWasNotPassedException;
use Api\Validators\ValidatorInterface;

class UpdateUserDataValidator extends AbstractUserDataValidator implements ValidatorInterface
{
  public function validate(array $data): array
  {
    $correctData = [];

    if(isset($data['email']))
    {
      $this->emailValidate($data);
      $correctData['email'] = $data['email'];
    }

    if(isset($data['password']))
    {
      $this->passwordValidate($data);
      $correctData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    }

    if(isset($data['name']))
    {
      $this->nameAndSurnameValidate($data);
      $correctData['name'] = $data['name'];
    }

    if(isset($data['surname']))
    {
      $this->nameAndSurnameValidate($data);
      $correctData['surname'] = $data['surname'];
    }

    if(isset($data['company']))
    {
      $this->companyNameValidate($data);
      $correctData['company'] = $data['company'];
    }

    if(empty($correctData))
      throw new DataToUpdateWasNotPassedException();

    return $correctData;
  }
}
