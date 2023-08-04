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

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Function to list all companies
    public function listCompanies() {
        $query = "SELECT * FROM emp_companies";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Function to create a job position inside a company
    public function createJobPosition($company_id, $name, $job_description, $job_level_name, $job_level_code, $title, $department, 
                                        $position_description, $skill, $location, $salary_range, $status) {
        $query1 = "INSERT INTO emp_jobs (company_id, name, description) VALUES ($company_id, '$name', '$job_description')";
        $stmt1 = $this->pdo->prepare($query1);
        $stmt1->execute(array(
            ':company_id' => $company_id,
            ':job_name' => $name,
            ':job_description' => $job_description
        ));

        $job_id = $this->pdo->lastInsertId();

        // Prepare and execute the second query to insert into emp_job_levels
        $query2 = "INSERT INTO emp_job_levels (company_id, job_id, name, code) VALUES (:company_id, :job_id, :job_level_name, :job_level_code)";
        $stmt2 = $this->pdo->prepare($query2);
        $stmt2->execute(array(
            ':company_id' => $company_id,
            ':job_id' => $job_id,
            ':job_level_name' => $job_level_name,
            ':job_level_code' => $job_level_code
        ));

        $job_level_id = $this->pdo->lastInsertId();

        // Prepare and execute the second query to insert into emp_job_levels
        $query3 = "INSERT INTO emp_job_positions (company_id, job_level_id, title, department , description , skill , location , salary_range , status) 
                    VALUES (:company_id, :job_level_id, :position_title, :position_department, :position_description, :position_skill,
                    :position_location,:position_salary_range,:position_status)";

        $stmt2 = $this->pdo->prepare($query3);
        $stmt2->execute(array(
            ':company_id' => $company_id,
            ':job_level_id' => $job_level_id,
            ':position_title' => $title,
            ':position_department' => $department,
            ':position_description' => $position_description,
            ':position_skill' => $skill,
            ':position_location' => $location,
            ':position_salary_range' => $salary_range,
            ':position_status' => $status
        ));

        $this->pdo = null; // Close the database connection
        return true;
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