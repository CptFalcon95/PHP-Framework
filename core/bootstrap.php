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
    App::bind('template_data', $data);
    require __DIR__."/../app/views/{$name}.view.php";
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

function requireTemplate($filePath) {
    extract(App::get('template_data'));
    return require __DIR__."/../app/views/{$filePath}.php";
}

function dd()
{
    $productionEnv = $_ENV['PROD'];
    if($productionEnv === "false") {
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
}