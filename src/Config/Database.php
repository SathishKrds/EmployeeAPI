<?php

namespace Config;

class Database
{
    public static function getConfig(): array
    {
        return [
            'host' => 'localhost',
            'database' => 'employees',
            'username' => 'root',
            'password' => 'password',
        ];
    }
}

?>