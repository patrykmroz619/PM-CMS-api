<?php

declare(strict_types=1);

namespace Api\Services;

use Api\Models\UserModel;

class UserService {
  private UserModel $userModel;

  public function __construct()
  {
    $this->userModel = new UserModel();
  }
}
