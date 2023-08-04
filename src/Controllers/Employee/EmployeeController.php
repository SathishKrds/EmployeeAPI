<?php
namespace Controllers\Employee;

use Models\Employee\Employee;

class EmployeeController {
    private $employeeModel;
    public function __construct() {
        $this->employeeModel = new Employee();
    } 

    // public function listAllEmployees() {
    //     $employeeModel = new Employee();
    //     $employees = $employeeModel->getAllEmployees();

    //     // Create an associative array with the desired JSON format
    //     $response = [
    //         'status' => 'success',
    //         'status_code' => 200,
    //         'data' => $employees,
    //     ];

    //     // Return the response as JSON
    //     header('Content-Type: application/json');
    //     echo json_encode($response);
    // }
    // Function to onboard an employee
    public function onboardEmployee() {
        $company_id = $_REQUEST['company_id'];
        $job_id = $_REQUEST['job_id'];
        $name = $_REQUEST['name'];
        $details = $_REQUEST['details'];
        $qualifications = $_REQUEST['qualifications'];
        $salary = $_REQUEST['salary'];

        $onboardEmployee = $this->employeeModel->onboardEmployee($company_id, $job_id, $name, $details, $qualifications, $salary);
        $response = [
            'status' => 'success',
            'status_code' => 200,
            'message' => "New employee '{$name}' onboarded!"
        ];        

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

?>