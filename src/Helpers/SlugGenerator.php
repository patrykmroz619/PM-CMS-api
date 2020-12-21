<?php

declare(strict_types=1);

namespace Api\Helpers;

class SlugGenerator
{
  static public function createSlug(string $text): string
  {
    $pattern = '/[^A-Za-z0-9-]+/';

    $slug = preg_replace($pattern, '-', $text);
    return $slug;
  }
}
