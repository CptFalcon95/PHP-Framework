<?php

namespace App\Core;

class Response extends App
{
    public static function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_FORCE_OBJECT);
        exit();
    }
}