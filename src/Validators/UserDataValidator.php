<?php

declare (strict_types=1);

namespace Validators;

use AppExceptions\SignInExceptions\PasswordInvalidException;
use AppExceptions\SignInExceptions\UserNotFoundException;
use AppExceptions\SignUpExceptions\EmailWasNotPassedException;
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
    $this->isDataValid();

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

  private function isDataValid(): void
  {
    $this->isEmailValid();
    $this->isPasswordValid();
  }

  private function isEmailValid(): void
  {
    if(!isset($this->userData['email']))
      throw new EmailWasNotPassedException();
  }

  private function isPasswordValid(): void
  {
    if(!isset($this->userData['password']))
      throw new PasswordWasNotPassedException();
  }
}
