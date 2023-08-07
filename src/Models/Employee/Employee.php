<?php
namespace Models\Employee;

use Config\Database;

class Employee
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function onboardEmployee($company_id, $job_id, $name, $details, $qualifications, $salary,
                                    $cert_name, $cert_url, $cert_completion_date, $cert_expiry_date, $cert_status, $cert_level, $cert_additional_notes,
                                    $prev_exp_name, $prev_exp_job_title, $prev_exp_start_date, $prev_exp_end_date, $prev_exp_job_responsibilities, 
                                    $prev_exp_employment_location, $prev_exp_employment_type, $prev_exp_reason_for_leaving, $prev_exp_additional_notes) 
    {
        $insertQuery = "INSERT INTO emp_employees 
                        (company_id, job_id, name, details, qualifications, salary) 
                        VALUES 
                        (:company_id, :job_id, :name, :details, :qualifications, :salary)";
        
        $stmt = $this->pdo->prepare($insertQuery);
    
        $params = [
            'company_id' => $company_id,
            'job_id' => $job_id,
            'name' => $name,
            'details' => $details,
            'qualifications' => $qualifications,
            'salary' => $salary
        ];
    
        $stmt->execute($params);
        
        $employeeId = $this->pdo->lastInsertId();
    
        $insertQuery = "INSERT INTO emp_certifications 
                        (employee_id, name, url, completion_date, expiry_date, status, level, additional_notes) 
                        VALUES 
                        (:employee_id, :cert_name, :cert_url, :cert_completion_date, :cert_expiry_date, :cert_status,
                         :cert_level, :cert_additional_notes)";
        
        $params = [
            'employee_id' => $employeeId,
            'cert_name' => $cert_name,
            'cert_url' => $cert_url,
            'cert_completion_date' => $cert_completion_date,
            'cert_expiry_date' => $cert_expiry_date,
            'cert_status' => $cert_status,
            'cert_level' => $cert_level,
            'cert_additional_notes' => $cert_additional_notes
        ];
        
        $stmt = $this->pdo->prepare($insertQuery);
        $stmt->execute($params);
    
        $insertQuery = "INSERT INTO emp_previous_experiences 
                    (employee_id, name, job_title, start_date, end_date, job_responsibilites, employment_location, employment_type, reason_for_leaving, additional_notes) 
                    VALUES 
                    (:employee_id, :prev_exp_name, :prev_exp_job_title, :prev_exp_start_date, :prev_exp_end_date, 
                    :prev_exp_job_responsibilites, :prev_exp_employment_location, :prev_exp_employment_type, :prev_exp_reason_for_leaving, 
                    :prev_exp_additional_notes)";
        
        $params = [
            'employee_id' => $employeeId,
            'prev_exp_name' => $prev_exp_name,
            'prev_exp_job_title' => $prev_exp_job_title,
            'prev_exp_start_date' => $prev_exp_start_date,
            'prev_exp_end_date' => $prev_exp_end_date,
            'prev_exp_job_responsibilites' => $prev_exp_job_responsibilities,
            'prev_exp_employment_location' => $prev_exp_employment_location,
            'prev_exp_employment_type' => $prev_exp_employment_type,
            'prev_exp_reason_for_leaving' => $prev_exp_reason_for_leaving,
            'prev_exp_additional_notes' => $prev_exp_additional_notes
        ];
    
        $stmt = $this->pdo->prepare($insertQuery);
        $stmt->execute($params);
    
        $this->pdo = null;
        return "New employee '{$name}' onboarded!";
    }
    
    // Function to get all employees in a same company
    public function getEmployeesByCompany($company_id)
    {
        $query = "SELECT *
                  FROM emp_employees 
                  WHERE company_id = :company_id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':company_id', $company_id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Function to get all employees in a same job
    public function getEmployeesByJob($job_id) {
        $query = "SELECT *
                  FROM emp_employees 
                  WHERE job_id = :job_id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':job_id', $job_id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Function to get all employees in a specific salary range
    public function getEmployeesBySalaryRange($min_salary, $max_salary) {
        $query = "SELECT *
                  FROM emp_employees 
                  WHERE salary
                  BETWEEN $min_salary AND $max_salary";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Function to apply for resignation
    public function applyResignation($company_id, $employee_id) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) 
                                        FROM emp_resignations 
                                        WHERE company_id = :company_id 
                                        AND employee_id = :employee_id");
        $stmt->bindParam(':company_id', $company_id, \PDO::PARAM_INT);
        $stmt->bindParam(':employee_id', $employee_id, \PDO::PARAM_INT);
        $stmt->execute();
        
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
            return 'Already applied for resignation';
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO emp_resignations (company_id, employee_id) 
                                            VALUES (:company_id, :employee_id)");
            $stmt->bindParam(':company_id', $company_id, \PDO::PARAM_INT);
            $stmt->bindParam(':employee_id', $employee_id, \PDO::PARAM_INT);
            $stmt->execute();
            
            return 'Resignation applied!';
        }
    }

    // Function to approve or reject resignation
    public function updateResignationStatus($company_id, $employee_id, $status) {
        $query = "UPDATE emp_resignations 
                    SET status = :status
                    WHERE company_id = :company_id
                    AND employee_id = :employee_id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':company_id', $company_id, \PDO::PARAM_INT);
        $stmt->bindParam(':employee_id', $employee_id, \PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, \PDO::PARAM_STR);
        $stmt->execute();

        return 'Resignation status updated!';
    }
}

?>