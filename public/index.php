<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Dotenv\Dotenv;
use App\Core\{App, Router, Request, View};

require '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

require '../core/bootstrap.php';

$messages = parseJSONFile('../app/messages.json');
$config = parseJSONFile('../app/config.json');
App::bind('err_msgs', $messages->errors);
App::bind('succ_msgs', $messages->success);
App::bind('config', $config);

Router::load('../app/routes.php')
    ->direct(Request::uri(), Request::method());