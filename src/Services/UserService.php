<?php

declare(strict_types=1);

namespace Api\Services;

use Api\AppExceptions\UserExceptions\DeleteUserWasNotCompletedException;
use Api\Models\ProjectModel;
use Api\Models\UserModel;
use Api\Validators\UserDataValidator;

class UserService {
  private UserModel $userModel;
  private UserDataValidator $userDataValidator;

  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->userDataValidator = new UserDataValidator();
  }

  public function getUser(string $uid): array
  {
    return $this->userModel->getUserById($uid);
  }

  public function updateUserData(array $data): array
  {
    $updatedData = $this->userDataValidator->updateValidate($data);

    $this->userModel->updateById($data['uid'], $updatedData);
    $updatedUser = $this->userModel->getUserById($data['uid']);

    unset($updatedUser['refreshToken']);
    unset($updatedUser['password']);
    unset($updatedUser['_id']);

    return $updatedUser;
  }

  public function deleteUser(string $uid): void
  {
    $result = $this->userModel->delete($uid);

    if($result->getDeletedCount() == 0)
      throw new DeleteUserWasNotCompletedException();

    $projectModel = new ProjectModel();
    $projectModel->deleteManyByUserId($uid);
  }
}
