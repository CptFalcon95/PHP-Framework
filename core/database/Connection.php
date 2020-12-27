<?php

class Connection
{
    public static function make()
    {
        try 
        {
            return new PDO(
                $_ENV['DB_CONNECTION'].';dbname='.$_ENV['DB_NAME'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'],
            );
        } 
        catch (PDOException $e) 
        {
            die($e->getMessage());
        }
    }
}