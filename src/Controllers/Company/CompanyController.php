<?php
namespace Controllers\Company;

use Models\Company\Company;

class CompanyController {

    private $companyModel;

    public function __construct() {
        $this->companyModel = new Company();
    }
    
    public function createCompany() {
        $name = $_REQUEST['name'];
        $address = $_REQUEST['address'];
        $domain = $_REQUEST['domain'];

        $createCompany = $this->companyModel->createCompany($name, $address, $domain);
        $response = [
            'status' => 'success',
            'status_code' => 200,
            'message' => 'New company created!',
        ];

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function listCompanies() {
        $companyLists = $this->companyModel->listCompanies();
        $response = [
            'status' => 'success',
            'status_code' => 200,
            'data' => $companyLists,
        ];

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function listAllJobPositionByCompany() {
        // Get the company ID from the query parameter
        $companyId = isset($_GET['company']) ? (int)$_GET['company'] : 0;

        $jobPositions = $this->companyModel->getJobPositionsByCompany($companyId);

        // Create an associative array with the desired JSON format
        $response = [
            'status' => 'success',
            'status_code' => 200,
            'data' => $jobPositions,
        ];

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function createJobPosition() {
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

        $createJobPosition = $this->companyModel->createJobPosition($company_id, $name, $job_description, $job_level_name, $job_level_code, 
                                $title, $department, $position_description, $skill, $location, $salary_range, $status);
        
        $response = [
            'status' => 'success',
            'status_code' => 200,
            'message' => 'New job position created!',
        ];

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

?>