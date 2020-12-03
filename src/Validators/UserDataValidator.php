<?php

declare (strict_types=1);

namespace Api\Validators;

use Api\AppExceptions\SignUpExceptions\EmailWasNotPassedException;
use Api\AppExceptions\SignUpExceptions\InvalidCompanyNameException;
use Api\AppExceptions\SignUpExceptions\InvalidEmailException;
use Api\AppExceptions\SignUpExceptions\InvalidNameException;
use Api\AppExceptions\SignUpExceptions\InvalidSurnameException;
use Api\AppExceptions\SignUpExceptions\PasswordWasNotPassedException;

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

  private function emailValidate(array $userData): bool
  {
    if(!isset($userData['email']))
      throw new EmailWasNotPassedException();

    $pattern = "/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i";
    if (
      !preg_match($pattern, $userData['email'])
      && strlen($userData['email'])  > 35
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
    $pattern = "/^[a-zA-Z][a-zA-Z-']{2,33}$/";

    if (
      isset($userData['name'])
      && !preg_match($pattern, $userData['name'])
      && strlen($userData['name']) > 35
    )
      throw new InvalidNameException();

    if (
      isset($userData['surname'])
      && !preg_match($pattern, $userData['surname'])
      && strlen($userData['surname']) > 35
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
