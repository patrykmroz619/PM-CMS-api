<?php

declare(strict_types=1);

namespace Api\Services\Auth;

use Api\AppExceptions\SignUpExceptions\UserAlreadyExistsException;
use Api\Models\User\UserModel;
use Api\Validators\UserData\SignUpValidator;

class SignUpService extends AbstractAuthService
{
  private UserModel $userModel;
  private SignUpValidator $validator;

  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->validator = new SignUpValidator();
  }

  public function signUp(array $requestData): array
  {
    $dataToSave = $this->processData($requestData);

    $id = $this->userModel->create($dataToSave);

    $tokens = $this->getTokens($id);

    $newUser = array_merge($dataToSave, ['id' => $id]);

    return $this->createResponse($newUser, $tokens);
  }

  private function processData(array $requestData): array
  {
    $userData = $this->validator->validate($requestData);

    $isUserExist = $this->userModel->isExistWithEmail($userData['email']);
    if($isUserExist) throw new UserAlreadyExistsException();

    $dataToSave = [
      'email' => $userData['email'],
      'name' => $userData['name'],
      'surname' => $userData['surname'],
      'company' => $userData['company'],
      'password' => password_hash($userData['password'], PASSWORD_DEFAULT)
    ];

    return $dataToSave;
  }
}
