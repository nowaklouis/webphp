<?php

namespace App;

use \PDO;

class Connect
{

    public static function getPDO(): PDO
    {
        require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'key.php';

        return new PDO('mysql:host=localhost;dbname=tutophp', $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
