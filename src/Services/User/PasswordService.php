<?php

declare(strict_types=1);

namespace Api\Services\User;

use Api\AppExceptions\SignUpExceptions\PasswordWasNotPassedException;
use Api\AppExceptions\UserExceptions\InvalidCurrentPasswordException;
use Api\AppExceptions\UserExceptions\InvalidNewPasswordException;
use Api\AppExceptions\UserExceptions\PasswordWasNotUpdatedException;
use Api\Models\User\UserModel;
use Api\Validators\Password\PasswordValidator;

class PasswordService {
  private UserModel $userModel;
  private PasswordValidator $passwordValidator;

  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->passwordValidator = new PasswordValidator();
  }

  public function updatePassword(string $uid, ?string $currentPassword, ?string $newPassword): bool
  {
    $user = $this->userModel->findById($uid);

    $this->validateCurrentPassword($currentPassword, $user['password']);
    $this->validateNewPassword($newPassword);

    $updateResult = $this->userModel->update($uid, ['password' => password_hash($newPassword, PASSWORD_DEFAULT)]);

    if($updateResult->getModifiedCount() == 0)
      throw new PasswordWasNotUpdatedException();

    return true;
  }

  private function validateCurrentPassword(?string $currentPassword, string $encryptedPassword): void
  {
    if(!$currentPassword)
      throw new PasswordWasNotPassedException();

    $isCurrentPasswordValid = password_verify($currentPassword, $encryptedPassword);

    if(!$isCurrentPasswordValid)
      throw new InvalidCurrentPasswordException();
  }

  private function validateNewPassword(?string $newPassword): void
  {
    if(!$newPassword)
      throw new PasswordWasNotPassedException();

    $isNewPasswordValid = $this->passwordValidator->validate($newPassword);

    if(!$isNewPasswordValid)
      throw new InvalidNewPasswordException();
  }
}
