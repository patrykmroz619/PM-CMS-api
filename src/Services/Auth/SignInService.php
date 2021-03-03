<?php

declare(strict_types=1);

namespace Api\Services\Auth;

use Api\AppExceptions\SignInExceptions\PasswordInvalidException;
use Api\Models\User\UserModel;
use Api\Validators\UserData\SignInValidator;

class SignInService extends AbstractAuthService
{
  private UserModel $userModel;
  private SignInValidator $validator;

  public function __construct()
  {
    $this->userModel = new UserModel();
    $this->validator = new SignInValidator();
  }

  public function signIn(array $requestData): array
  {
    $signInData = $this->validator->validate($requestData);
    $user = $this->userModel->findByEmail($signInData['email']);

    $this->checkPassword($signInData['password'], $user['password']);

    $tokens = $this->getTokens($user['id']);
    $this->userModel->update($user['id'], ['refreshToken' => $tokens['refreshToken']]);

    $responseData = $this->createResponse($user, $tokens);
    return $responseData;
  }

  private function checkPassword(string $passedPassword, string $encryptedPassword): void
  {
    $isCorrect = password_verify($passedPassword, $encryptedPassword);

    if(!$isCorrect)
      throw new PasswordInvalidException();
  }
}
