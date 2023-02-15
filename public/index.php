<?php
ob_start();

define('PUBLIC_DIR', __DIR__ . DIRECTORY_SEPARATOR);
define('APP_DIR', realpath(__DIR__ . '/../src/') . DIRECTORY_SEPARATOR);

require_once APP_DIR.'../vendor/autoload.php';
require_once APP_DIR . 'main.php';
