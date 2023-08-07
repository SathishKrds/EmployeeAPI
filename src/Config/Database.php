<?php

namespace Config;

class Database
{
    private static $pdo = null;

    public static function getConfig(): array
    {
        return [
            'host' => 'localhost',
            'database' => 'employees',
            'username' => 'root',
            'password' => 'password',
        ];
    }

    public static function getConnection(): \PDO
    {
        if (self::$pdo === null) {
            $config = self::getConfig();

            $dsn = "mysql:host={$config['host']};dbname={$config['database']}";
            self::$pdo = new \PDO($dsn, $config['username'], $config['password']);
            self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo;
    }
}
?>
