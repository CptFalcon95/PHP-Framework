<?php

use App\Core\App;

$app = [];

App::bind('config', $config = require '../config.php');

$config = App::get('config');

App::bind('database', new QueryBuilder(
    Connection::make($config['database'])
));

function view($name, $data = [])
{
    extract($data);
    return require "../app/views/{$name}.view.php";
}

function redirect($path)
{
    header("Location: {$path}");
}

function dd()
{
    $args = func_get_args();
    if (count($args))
    {
        echo "<pre>";
        foreach ($args as $arg)
        {
            var_dump($arg);
        }
        echo "</pre>";
        die();
    }
}