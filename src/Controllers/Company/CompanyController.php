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
}

?>