<?php

use App\Core\App;

$app = [];

App::bind('database', new QueryBuilder(
    Connection::make()
));

App::get('database')->pdo()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


/* 
// Quick way to have some functions ready to use
*/
function view($name, $data = [])
{
    extract($data);
    return require "../app/views/{$name}.view.php";
}

function redirect($path)
{
    header("Location: {$path}");
}

function parseJSONFile($filename)
{
    $path = "../app/";
    if (!file_exists($path.$filename)) {
        throw new Exception("File not found in App directory. Path is relative to app directory");
    }
    return json_decode(file_get_contents($filename));
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