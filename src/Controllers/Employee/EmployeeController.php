<?php
namespace Controllers\Employee;

use Models\Employee\Employee;

class EmployeeController {
    public function __construct() {
        // echo "employee";
    } 

    public function listAllEmployees() {
        $employeeModel = new Employee();
        $employees = $employeeModel->getAllEmployees();

        // Create an associative array with the desired JSON format
        $response = [
            'status' => 'success',
            'data' => $employees,
        ];

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

?>