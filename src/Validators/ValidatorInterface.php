<?php

declare(strict_types=1);

namespace Api\Validators;

interface ValidatorInterface
{
  public function validate(array $data): array;
}
