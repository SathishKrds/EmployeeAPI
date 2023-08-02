<?php
// controllers
// use Controllers\Employee\EmployeeController as EmployeeController;
// use Controllers\Company\CompanyController as CompanyController;

use Controllers\Company\CompanyController;
use Controllers\Employee\EmployeeController;

// models
use Models\Employee\Employee as Employee;
use Models\Company\Company as Company;

use Config\Router as Router;

require_once __DIR__ . '/vendor/autoload.php';

// $emp = new EmployeeController();
// $comp = new CompanyController();

// $emp_model = new Employee();
// $comp_model = new Company();

$router = new Router();

// Add routes with controller methods
$router->get('/jobposition', 'Company/CompanyController@listAllJobPositionByCompany');
$router->get('/employee', 'Employee/EmployeeController@listAllEmployees');

// Dispatch the request
$router->dispatch();

?>