<?php

namespace App\Core;

class Hash
{
    public static function password($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}