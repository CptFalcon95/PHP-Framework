<?php

namespace App\Core;

class Hash
{
    public static function password($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function randomString($stringLength) {
        return substr(sha1(time()), 0, $stringLength); 
    }
}