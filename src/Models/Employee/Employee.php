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

    // public function getAllEmployees()
    // {
    //     $query = "SELECT * FROM emp_employees";
    //     $stmt = $this->pdo->query($query);

    //     return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    // }

    public function onboardEmployee($company_id, $job_id, $name, $details, $qualifications, $salary) {
        $query = "INSERT INTO emp_employees (company_id, job_id, name, details, qualifications, salary) 
                                VALUES (:company_id, :job_id, :name, :details, :qualifications, :salary)";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'company_id' => $company_id,
            'job_id' => $job_id,
            'name' => $name,
            'details' => $details,
            'qualifications' => $qualifications,
            'salary' => $salary
        ]);

        $this->pdo = null;
        return true;
    }
}

?>