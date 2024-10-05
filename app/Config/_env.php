<?php declare (strict_types = 1);

define("BASE_PATH", realpath(__DIR__ . '/../../'));

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::create(BASE_PATH);
$dotenv->load();

require_once __DIR__ . '/_stripe.php';