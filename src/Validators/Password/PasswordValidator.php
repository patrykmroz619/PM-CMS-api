<?php

declare(strict_types=1);

namespace Api\Validators\Password;

use Api\AppExceptions\UserExceptions\PasswordException;

class PasswordValidator {
  public function validate(string $password)
  {
    $passwordLength = strlen($password);
    $numberRegex = "/\d/";
    $upperLetterRegex = "/[A-Z]/";

    if($passwordLength < 5)
      throw new PasswordException('Password has to be longer than 4 characters.');

    if(!preg_match($numberRegex, $password))
      throw new PasswordException('Password should contain some numbers.');

    if(!preg_match($upperLetterRegex, $password))
      throw new PasswordException('Password should contain some uppercase letter.');

    return true;
  }
}
