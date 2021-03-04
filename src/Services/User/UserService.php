<?php

declare(strict_types=1);

namespace Api\Services\User;

use Api\AppExceptions\UserExceptions\DeleteUserWasNotCompletedException;
use Api\Models\Project\ProjectModel;
use Api\Models\User\UserModel;
use Api\Services\Project\DeleteProjectService;
use Api\Validators\UserData\UpdateUserDataValidator;

class UserService {
  private UserModel $userModel;
  private UpdateUserDataValidator $validator;
  private DeleteProjectService $deleteProjectService;

  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->validator = new UpdateUserDataValidator();
    $this->deleteProjectService = new DeleteProjectService();
  }

  public function getUser(string $userId): array
  {
    return $this->userModel->findById($userId);
  }

  public function updateUserData(array $data): array
  {
    $updatedData = $this->validator->validate($data);

    $userId = $data['uid'];

    $this->userModel->update($userId, $updatedData);
    $updatedUser = $this->userModel->findById($userId);

    unset($updatedUser['refreshToken']);
    unset($updatedUser['password']);
    unset($updatedUser['_id']);

    return $updatedUser;
  }

  public function deleteUser(string $uid): void
  {
    $complete = $this->userModel->delete($uid);

    if(!$complete)
      throw new DeleteUserWasNotCompletedException();

    $this->deleteProjectService->deleteManyByUserId($uid);
  }
}
