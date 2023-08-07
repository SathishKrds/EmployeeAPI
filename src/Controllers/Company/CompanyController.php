<?php
namespace Controllers\Company;

use Models\Company\Company;

class CompanyController {

    private $companyModel;

    public function __construct() {
        $this->companyModel = new Company();
    }
    
    public function createCompany() {
        try {
            $name = $_REQUEST['name'];
            $address = $_REQUEST['address'];
            $domain = $_REQUEST['domain'];
    
            // Input data validation
            if (empty($name) || empty($address) || empty($domain)) {
                throw new \Exception("Missing required data.");
            }
    
            $response = [
                'status' => 'success',
                'status_code' => 200,
                'message' => $this->companyModel->createCompany($name, $address, $domain),
            ];
    
            // Return the response as JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (\Exception $e) {
            // Handle errors
            $response = [
                'status' => 'error',
                'status_code' => 400,
                'message' => $e->getMessage(),
            ];
    
            // Return the error response as JSON
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode($response);
        }
    }

    public function listCompanies() {
        try {
            $companyLists = $this->companyModel->getCompanies();
            $response = [
                'status' => 'success',
                'status_code' => 200,
                'data' => $companyLists,
            ];
    
            // Return the response as JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (\Exception $e) {
            // Return an error response to the client
            $response = [
                'status' => 'error',
                'status_code' => 500,
                'message' => 'Internal server error',
            ];
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
    

    public function listAllJobPositionByCompany() {
        $error = null;
    
        // Get the company ID from the query parameter
        $companyId = isset($_GET['company']) ? $_GET['company'] : null;
    
        if (!empty($companyId)) {
            try {
                $jobPositions = $this->companyModel->getJobPositionsByCompany($companyId);
    
                // Create an associative array with the desired JSON format
                $response = [
                    'status' => 'success',
                    'status_code' => 200,
                    'data' => $jobPositions,
                ];
            } catch (\Exception $e) {
                $error = 'An error occurred while fetching job positions.';
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

    public function createJobPosition() {
        try {
            $company_id = $_REQUEST['company_id'];
            $name = $_REQUEST['job_name']; 
            $job_description = $_REQUEST['job_description']; 
            $job_level_name = $_REQUEST['job_level_name']; 
            $job_level_code = $_REQUEST['job_level_code'];
            $title = $_REQUEST['position_title'];
            $department = $_REQUEST['position_department'];
            $position_description = $_REQUEST['position_description'];
            $skill = $_REQUEST['position_skill'];
            $location = $_REQUEST['position_location'];
            $salary_range = $_REQUEST['position_salary_range'];
            $status = $_REQUEST['position_status'];
    
            // Check if required input fields are empty
            if (empty($company_id) || empty($name) || empty($job_description) || empty($job_level_name) || empty($job_level_code) ||
                empty($title) || empty($department) || empty($position_description) || empty($skill) || empty($location) ||
                empty($salary_range) || empty($status)) {
                    
                throw new \Exception('Required input fields are missing');
            }
            
            $response = [
                'status' => 'success',
                'status_code' => 200,
                'message' => $this->companyModel->createJobPosition($company_id, $name, $job_description, $job_level_name, $job_level_code, 
                $title, $department, $position_description, $skill, $location, $salary_range, $status)
            ];
    
            // Return the response as JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'status_code' => 400,
                'message' => $e->getMessage(),
            ];
    
            // Return the error response as JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}

?>