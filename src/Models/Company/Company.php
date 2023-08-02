<?php
namespace Models\Company;

use Config\Database;

class Company
{
    private $pdo;

    public function __construct()
    {
        $config = Database::getConfig();
        $dsn = "mysql:host={$config['host']};dbname={$config['database']}";
        $this->pdo = new \PDO($dsn, $config['username'], $config['password']);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getJobPositionsByCompany($companyId)
    {
        $query = "SELECT jp.*
                  FROM emp_job_positions jp
                  JOIN emp_companies c ON jp.company_id = c.id
                  WHERE c.id = :companyId";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':companyId', $companyId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>