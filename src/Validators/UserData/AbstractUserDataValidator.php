<?php

declare(strict_types=1);

namespace Api\Validators\UserData;

use Api\AppExceptions\SignUpExceptions\EmailWasNotPassedException;
use Api\AppExceptions\UserExceptions\InvalidCompanyNameException;
use Api\AppExceptions\UserExceptions\InvalidEmailException;
use Api\AppExceptions\UserExceptions\InvalidNameException;
use Api\AppExceptions\UserExceptions\InvalidSurnameException;
use Api\AppExceptions\SignUpExceptions\PasswordWasNotPassedException;

abstract class AbstractUserDataValidator
{
  protected function emailValidate(array $userData): bool
  {
    if(!isset($userData['email']))
      throw new EmailWasNotPassedException();

    if (
      !filter_var($userData['email'], FILTER_VALIDATE_EMAIL)
      || strlen($userData['email'])  > 35
    )
      throw new InvalidEmailException();

    return true;
  }

  protected function passwordValidate(array $userData): bool
  {
    if(!isset($userData['password']))
      throw new PasswordWasNotPassedException();

    return true;
  }

  protected function nameAndSurnameValidate(array $userData): bool
  {
    $pattern = "/^[a-zA-ZąĄćĆęĘśŚóÓłŁńŃżŻźŹ][a-zA-ZąĄćĆęĘśŚóÓłŁńŃżŻźŹ ,'-]+$/u";
    if(isset($userData['name']) && $userData['name'] != '')
    {
      if (!preg_match($pattern, $userData['name']) || strlen($userData['name']) > 35)
        throw new InvalidNameException();
    }

    if(isset($userData['surname']) && $userData['surname'] != '')
    {
      if (!preg_match($pattern, $userData['surname']) || strlen($userData['surname']) > 35)
        throw new InvalidSurnameException();
    }

    return true;
  }

  protected function companyNameValidate(array $userData): bool
  {
    if(isset($userData['company']) && $userData['company'] != '')
    {
      if (strlen($userData['company']) > 35)
        throw new InvalidCompanyNameException();
    }

    return true;
  }
}
