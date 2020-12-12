<?php

declare (strict_types=1);

namespace Api\Validators;

use Api\AppExceptions\SignUpExceptions\EmailWasNotPassedException;
use Api\AppExceptions\SignUpExceptions\InvalidCompanyNameException;
use Api\AppExceptions\SignUpExceptions\InvalidEmailException;
use Api\AppExceptions\SignUpExceptions\InvalidNameException;
use Api\AppExceptions\SignUpExceptions\InvalidSurnameException;
use Api\AppExceptions\SignUpExceptions\PasswordWasNotPassedException;
use Api\AppExceptions\UserExceptions\DataToUpdateWasNotPassedException;

class UserDataValidator {
  public function signUpValidate(array $userData): array
  {
    $this->emailValidate($userData);
    $this->passwordValidate($userData);
    $this->nameAndSurnameValidate($userData);
    $this->companyNameValidate($userData);

    $correctData = [
      'email' => $userData['email'],
      'password' => $userData['password'],
      'name' => $userData['name'] ?? null,
      'surname' => $userData['surname'] ?? null,
      'company' => $userData['company'] ?? null
    ];

    return $correctData;
  }

  public function signInValidate(array $userData): array
  {
    $this->emailValidate($userData);
    $this->passwordValidate($userData);

    $correctData = [
      'email' => $userData['email'],
      'password' => $userData['password']
    ];

    return $correctData;
  }

  public function updateValidate(array $userData): array
  {
    $correctData = [];
    if(isset($userData['email']))
    {
      $this->emailValidate($userData);
      $correctData['email'] = $userData['email'];
    }

    if(isset($userData['password']))
    {
      $this->passwordValidate($userData);
      $correctData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
    }

    if(isset($userData['name']))
    {
      $this->nameAndSurnameValidate($userData);
      $correctData['name'] = $userData['name'];
    }

    if(isset($userData['surname']))
    {
      $this->nameAndSurnameValidate($userData);
      $correctData['surname'] = $userData['surname'];
    }

    if(isset($userData['company']))
    {
      $this->companyNameValidate($userData);
      $correctData['company'] = $userData['company'];
    }

    if(empty($correctData))
      throw new DataToUpdateWasNotPassedException();

    return $correctData;
  }

  private function emailValidate(array $userData): bool
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

  private function passwordValidate(array $userData): bool
  {
    if(!isset($userData['password']))
      throw new PasswordWasNotPassedException();

    return true;
  }

  private function nameAndSurnameValidate(array $userData): bool
  {
    $pattern = "/^[a-zA-ZąĄćĆęĘśŚóÓłŁńŃżŻźŹ][a-zA-ZąĄćĆęĘśŚóÓłŁńŃżŻźŹ ,'-]+$/u";

    if (
      isset($userData['name'])
      && (!preg_match($pattern, $userData['name'])
      || strlen($userData['name']) > 35)
    )
      throw new InvalidNameException();

    if (
      isset($userData['surname'])
      && (!preg_match($pattern, $userData['surname'])
      || strlen($userData['surname']) > 35)
    )
      throw new InvalidSurnameException();

    return true;
  }

  private function companyNameValidate(array $userData): bool
  {
    if (
      isset($userData['company'])
      && strlen($userData['company']) > 35
    )
      throw new InvalidCompanyNameException();

    return true;
  }
}
