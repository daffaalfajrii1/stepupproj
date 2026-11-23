<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$root = dirname(__DIR__);
if (! is_file($root.'/vendor/autoload.php') && is_file($root.'/stepup/vendor/autoload.php')) {
    $root = $root.'/stepup';
}

if (file_exists($maintenance = $root.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $root.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $root.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
