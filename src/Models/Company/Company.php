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

    // Function to create a new company
    public function createCompany($name, $address, $domain) {
        $query = "INSERT INTO emp_companies (name, address, domain) VALUES ('$name', '$address', '$domain')";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return 'New company created!';
    }

    // Function to list all companies
    public function getCompanies() {
        $query = "SELECT * FROM emp_companies";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Function to create a job position inside a company
    public function createJobPosition($company_id, $name, $job_description, $job_level_name, $job_level_code, $title, $department, 
                                        $position_description, $skill, $location, $salary_range, $status) {
        $this->pdo->beginTransaction();
        $insertJobQuery = "INSERT INTO emp_jobs (company_id, name, description) VALUES (:company_id, :job_name, :job_description)";
        $stmt1 = $this->pdo->prepare($insertJobQuery);
        $stmt1->bindValue(':company_id', $company_id);
        $stmt1->bindValue(':job_name', $name);
        $stmt1->bindValue(':job_description', $job_description);
        $stmt1->execute();

        $job_id = $this->pdo->lastInsertId();

        $insertJobLevelQuery = "INSERT INTO emp_job_levels (company_id, job_id, name, code) VALUES (:company_id, :job_id, :job_level_name, :job_level_code)";
        $stmt2 = $this->pdo->prepare($insertJobLevelQuery);
        $stmt2->bindValue(':company_id', $company_id);
        $stmt2->bindValue(':job_id', $job_id);
        $stmt2->bindValue(':job_level_name', $job_level_name);
        $stmt2->bindValue(':job_level_code', $job_level_code);
        $stmt2->execute();

        $job_level_id = $this->pdo->lastInsertId();

        $insertJobPositionQuery = "INSERT INTO emp_job_positions (company_id, job_level_id, title, department, description, skill, location, salary_range, status)
            VALUES (:company_id, :job_level_id, :position_title, :position_department, :position_description, :position_skill, :position_location, :position_salary_range, :position_status)";
        $stmt3 = $this->pdo->prepare($insertJobPositionQuery);
        $stmt3->bindValue(':company_id', $company_id);
        $stmt3->bindValue(':job_level_id', $job_level_id);
        $stmt3->bindValue(':position_title', $title);
        $stmt3->bindValue(':position_department', $department);
        $stmt3->bindValue(':position_description', $position_description);
        $stmt3->bindValue(':position_skill', $skill);
        $stmt3->bindValue(':position_location', $location);
        $stmt3->bindValue(':position_salary_range', $salary_range);
        $stmt3->bindValue(':position_status', $status);
        $stmt3->execute();

        $this->pdo->commit();
        return 'New job position created!';
    }

    // Function to list all job positions in a company
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