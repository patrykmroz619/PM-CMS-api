<?php

declare(strict_types=1);

use Helpers\EnvLoader;

require __DIR__ . '/../vendor/autoload.php';

EnvLoader::load();

include_once "./app/api.php";


