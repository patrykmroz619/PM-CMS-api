<?php

declare(strict_types=1);

namespace Api\Validators\UserData;

use Api\Validators\ValidatorInterface;

class SignUpValidator extends AbstractUserDataValidator implements ValidatorInterface
{
  public function validate(array $data): array
  {
    $this->emailValidate($data);
    $this->passwordValidate($data);
    $this->nameAndSurnameValidate($data);
    $this->companyNameValidate($data);

    $correctData = [
      'email' => $data['email'],
      'password' => $data['password'],
      'name' => $data['name'] ?? null,
      'surname' => $data['surname'] ?? null,
      'company' => $data['company'] ?? null
    ];

    return $correctData;
  }
}
