<?php
namespace Controllers\Company;

use Models\Company\Company;

class CompanyController {
    public function __construct() {
        // echo "company";
    }
    
    public function listAllJobPositionByCompany() {
        // Get the company ID from the query parameter
        $companyId = isset($_GET['company']) ? (int)$_GET['company'] : 0;

        $companyModel = new Company();
        $jobPositions = $companyModel->getJobPositionsByCompany($companyId);

        // Create an associative array with the desired JSON format
        $response = [
            'status' => 'success',
            'data' => $jobPositions,
        ];

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

?>