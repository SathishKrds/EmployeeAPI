<?php
namespace Controllers\Employee;

use Models\Employee\Employee;

class EmployeeController {
    private $employeeModel;
    public function __construct() {
        $this->employeeModel = new Employee();
    } 

    // Function to onboard an employee
    public function onboardEmployee()
    {
        $company_id = $_REQUEST['company_id'] ?? null;
        $job_id = $_REQUEST['job_id'] ?? null;
        $name = $_REQUEST['name'] ?? null;
        $details = $_REQUEST['details'] ?? null;
        $qualifications = $_REQUEST['qualifications'] ?? null;
        $salary = $_REQUEST['salary'] ?? null;

        $cert_name = $_REQUEST['cert_name'] ?? null;
        $cert_url = $_REQUEST['cert_url'] ?? null;
        $cert_completion_date = $_REQUEST['cert_completion_date'] ?? null;
        $cert_expiry_date = $_REQUEST['cert_expiry_date'] ?? null;
        $cert_status = $_REQUEST['cert_status'] ?? null;
        $cert_level = $_REQUEST['cert_level'] ?? null;
        $cert_additional_notes = $_REQUEST['cert_additional_notes'] ?? null;

        $prev_exp_name = $_REQUEST['prev_exp_name'] ?? null;
        $prev_exp_job_title = $_REQUEST['prev_exp_job_title'] ?? null;
        $prev_exp_start_date = $_REQUEST['prev_exp_start_date'] ?? null;
        $prev_exp_end_date = $_REQUEST['prev_exp_end_date'] ?? null;
        $prev_exp_job_responsibilities = $_REQUEST['prev_exp_job_responsibilities'] ?? null;
        $prev_exp_employment_location = $_REQUEST['prev_exp_employment_location'] ?? null;
        $prev_exp_employment_type = $_REQUEST['prev_exp_employment_type'] ?? null;
        $prev_exp_reason_for_leaving = $_REQUEST['prev_exp_reason_for_leaving'] ?? null;
        $prev_exp_additional_notes = $_REQUEST['prev_exp_additional_notes'] ?? null;

        // Validate the required fields
        // $requiredFields = [
        //     $company_id, $job_id, $name, $details, $qualifications, $salary,
        //     $cert_name, $cert_url, $cert_completion_date, $cert_expiry_date, $cert_status,
        //     $cert_level, $cert_additional_notes, $prev_exp_name, $prev_exp_job_title,
        //     $prev_exp_start_date, $prev_exp_end_date, $prev_exp_job_responsibilities,
        //     $prev_exp_employment_location, $prev_exp_employment_type, $prev_exp_reason_for_leaving,
        //     $prev_exp_additional_notes
        // ];

        // foreach ($requiredFields as $field) {
        //     if (empty($field)) {
        //         header('Content-Type: application/json');
        //         echo json_encode([
        //             'status' => 'error',
        //             'status_code' => 400,
        //             'message' => 'Required fields are missing or empty.'
        //         ]);
        //         die;
        //     }
        // }

        try {
            $response = [
                'status' => 'success',
                'status_code' => 200,
                'message' => $this->employeeModel->onboardEmployee(
                    $company_id, $job_id, $name, $details, $qualifications, $salary,
                    $cert_name, $cert_url, $cert_completion_date, $cert_expiry_date, $cert_status,
                    $cert_level, $cert_additional_notes, $prev_exp_name, $prev_exp_job_title,
                    $prev_exp_start_date, $prev_exp_end_date, $prev_exp_job_responsibilities,
                    $prev_exp_employment_location, $prev_exp_employment_type, $prev_exp_reason_for_leaving,
                    $prev_exp_additional_notes
                )
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'status_code' => 500,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }

    public function listEmployeesByCompany() {
        $error = null;
    
        // Get the company ID from the query parameter
        $companyId = isset($_GET['company_id']) ? $_GET['company_id'] : null;
    
        if (!empty($companyId)) {
            try {
                $employees = $this->employeeModel->getEmployeesByCompany($companyId);
    
                // Create an associative array with the desired JSON format
                $response = [
                    'status' => 'success',
                    'status_code' => 200,
                    'data' => $employees,
                ];
            } catch (\Exception $e) {
                $error = 'An error occurred while fetching employees.';
            }
        } else {
            $error = 'No company ID provided.';
        }
    
        if ($error !== null) {
            $response = [
                'status' => 'error',
                'status_code' => 400,
                'message' => $error,
            ];
        }
    
        // Set the appropriate HTTP status code
        http_response_code($response['status_code']);
    
        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function listEmployeesByJob() {
        $error = null;
    
        // Get the company ID from the query parameter
        $jobId = isset($_GET['job_id']) ? $_GET['job_id'] : null;
    
        if (!empty($jobId)) {
            try {
                $employees = $this->employeeModel->getEmployeesByJob($jobId);
    
                // Create an associative array with the desired JSON format
                $response = [
                    'status' => 'success',
                    'status_code' => 200,
                    'data' => $employees,
                ];
            } catch (\Exception $e) {
                $error = 'An error occurred while fetching employees.';
            }
        } else {
            $error = 'No job ID provided.';
        }
    
        if ($error !== null) {
            $response = [
                'status' => 'error',
                'status_code' => 400,
                'message' => $error,
            ];
        }
    
        // Set the appropriate HTTP status code
        http_response_code($response['status_code']);
    
        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function listEmployeesBySalaryRange() {
        $error = null;
    
        // Get the company ID from the query parameter
        $minSalary = isset($_GET['min_salary']) ? $_GET['min_salary'] : null;
        $maxSalary = isset($_GET['max_salary']) ? $_GET['max_salary'] : null;
    
        if (!empty($minSalary) & !empty($maxSalary)) {
            try {
                $employees = $this->employeeModel->getEmployeesBySalaryRange($minSalary , $maxSalary);
    
                // Create an associative array with the desired JSON format
                $response = [
                    'status' => 'success',
                    'status_code' => 200,
                    'data' => $employees,
                ];
            } catch (\Exception $e) {
                $error = 'An error occurred while fetching employees.';
            }
        } else {
            $error = 'Required input fields are missing';
        }
    
        if ($error !== null) {
            $response = [
                'status' => 'error',
                'status_code' => 400,
                'message' => $error,
            ];
        }
    
        // Set the appropriate HTTP status code
        http_response_code($response['status_code']);
    
        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Function to apply for resignation
    public function applyResignation() {
        try {
            $company_id = $_REQUEST['company_id'];
            $employee_id = $_REQUEST['employee_id'];

            if (empty($company_id) || empty($employee_id)) {
                throw new \Exception('Missing required parameters');
            }

            $response = [
                'status' => 'success',
                'status_code' => 200,
                'message' => $this->employeeModel->applyResignation($company_id, $employee_id)
            ];        
    
            // Return the response as JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'status_code' => 500,
                'message' => $e->getMessage()
            ];
    
            // Return the error response as JSON
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode($response);
        }
    }

    // Function to approve or reject resignation
    public function updateResignationStatus() {
        try {
            $company_id = $_REQUEST['company_id'];
            $employee_id = $_REQUEST['employee_id'];
            $status = $_REQUEST['status'];
    
            // Check if the required parameters are missing
            if (empty($company_id) || empty($employee_id) || empty($status)) {
                throw new \Exception('Missing required parameters');
            }
    
            $message = $this->employeeModel->updateResignationStatus($company_id, $employee_id, $status);
    
            $response = [
                'status' => 'success',
                'status_code' => 200,
                'message' => $message
            ];        
    
            // Return the response as JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (\Exception $e) {
            // Handle any exceptions here
            $response = [
                'status' => 'error',
                'status_code' => 500,
                'message' => $e->getMessage()
            ];
            
            // Return the error response as JSON
            header('Content-Type: application/json');
            http_response_code($response['status_code']);
            echo json_encode($response);
        }
    }
}

?>