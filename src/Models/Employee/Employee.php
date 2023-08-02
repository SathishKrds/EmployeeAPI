<?php
namespace Models\Employee;

use Config\Database;

class Employee
{
    private $pdo;

    public function __construct()
    {
        $config = Database::getConfig();

        $dsn = "mysql:host={$config['host']};dbname={$config['database']}";
        $this->pdo = new \PDO($dsn, $config['username'], $config['password']);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getAllEmployees()
    {
        $query = "SELECT * FROM emp_employees";
        $stmt = $this->pdo->query($query);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>