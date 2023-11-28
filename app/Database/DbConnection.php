<?php

namespace App\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DbConnection
{
    private static ?Connection $connection = null;

    public static function getConnection(): Connection
    {
        if (self::$connection === null) {
            $connectionParams = [
                'dbname' => $_ENV['DB_NAME'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
                'host' => $_ENV['DB_HOST'],
                'driver' => $_ENV['DB_DRIVER'],
            ];
            self::$connection = DriverManager::getConnection($connectionParams);
        }

        return self::$connection;
    }
}
