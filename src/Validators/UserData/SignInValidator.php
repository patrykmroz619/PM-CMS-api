<?php

declare(strict_types=1);

namespace Api\Validators\UserData;

use Api\Validators\ValidatorInterface;

class SignInValidator extends AbstractUserDataValidator implements ValidatorInterface
{
  public function validate($data): array
  {
    $this->emailValidate($data);
    $this->passwordValidate($data);

    $correctData = [
      'email' => $data['email'],
      'password' => $data['password']
    ];

    return $correctData;
  }
}
