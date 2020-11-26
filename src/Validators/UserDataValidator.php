<?php

declare (strict_types=1);

namespace Validators;

use AppExceptions\SignInExceptions\PasswordInvalidException;
use AppExceptions\SignInExceptions\UserNotFoundException;
use AppExceptions\SignUpExceptions\EmailWasNotPassedException;
use AppExceptions\SignUpExceptions\InvalidCompanyNameException;
use AppExceptions\SignUpExceptions\InvalidEmailException;
use AppExceptions\SignUpExceptions\InvalidNameException;
use AppExceptions\SignUpExceptions\InvalidSurnameException;
use AppExceptions\SignUpExceptions\PasswordWasNotPassedException;
use AppExceptions\SignUpExceptions\UserAlreadyExistsException;
use Models\UserModel;
use MongoDB\Model\BSONDocument;

class UserDataValidator {
  private UserModel $userModel;
  private array $userData = [];

  public function signUpValidate(array $userData, UserModel $userModel): void
  {
    $this->userData = $userData;
    $this->userModel = $userModel;
    $this->isDataValid(true);

    $user = $this->getUser();
    if(!!$user)
      throw new UserAlreadyExistsException();
  }

  public function signInValidate(array $userData, UserModel $userModel): BSONDocument
  {
    $this->userData = $userData;
    $this->userModel = $userModel;
    $this->isDataValid();

    $user = $this->getUser();
    if(!$user)
      throw new UserNotFoundException();

    $isPasswordValid = password_verify($this->userData['password'], $user['password']);
    if (!$isPasswordValid)
      throw new PasswordInvalidException();

    return $user;
  }

  private function getUser(): ?BSONDocument
  {
    $filter = ['email' => $this->userData['email']];
    return $this->userModel->findOne($filter);
  }

  private function isDataValid(bool $register = false): void
  {
    $this->emailValidate();
    $this->passwordValidate();

    if($register){
      $this->nameAndSurnameValidate();
      $this->companyNameValidate();
    }
  }

  private function emailValidate(): void
  {
    if(!isset($this->userData['email']))
      throw new EmailWasNotPassedException();

    $pattern = "/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i";
    if (
      !preg_match($pattern, $this->userData['email'])
      && strlen($this->userData['email'])  > 35
    )
      throw new InvalidEmailException();
  }

  private function passwordValidate(): void
  {
    if(!isset($this->userData['password']))
      throw new PasswordWasNotPassedException();
  }

  private function nameAndSurnameValidate(): void
  {
    $pattern = "/^[a-zA-Z][a-zA-Z-']{2,33}$/";

    if (
      isset($this->userData['name'])
      && !preg_match($pattern, $this->userData['name'])
      && strlen($this->userData['name']) > 35
    )
      throw new InvalidNameException();

    if (
      isset($this->userData['surname'])
      && !preg_match($pattern, $this->userData['surname'])
      && strlen($this->userData['surname']) > 35
    )
      throw new InvalidSurnameException();
  }

  private function companyNameValidate(): void
  {
    if (
      isset($this->userData['company'])
      && strlen($this->userData['company']) > 35
    )
      throw new InvalidCompanyNameException();
  }
}
