<?php
namespace Routes;

use Config\Router as Router;

class Route
{
    private $router;

    public function __construct()
    {
        $this->router = new Router();
        $this->addRoutes();
    }

    public function addRoutes()
    {
        $this->router->get('/listAllJobPositionByCompany', 'Company/CompanyController@listAllJobPositionByCompany');
        $this->router->get('/listCompanies', 'Company/CompanyController@listCompanies');
        $this->router->post('/createCompany', 'Company/CompanyController@createCompany');
        $this->router->post('/createJobPosition', 'Company/CompanyController@createJobPosition');
        $this->router->post('/onboardEmployee', 'Employee/EmployeeController@onboardEmployee');
        $this->router->get('/listEmployeesByCompany', 'Employee/EmployeeController@listEmployeesByCompany');
        $this->router->get('/listEmployeesByJob', 'Employee/EmployeeController@listEmployeesByJob');
        $this->router->get('/listEmployeesBySalaryRange', 'Employee/EmployeeController@listEmployeesBySalaryRange');
        $this->router->post('/applyResignation', 'Employee/EmployeeController@applyResignation');
        $this->router->post('/updateResignationStatus', 'Employee/EmployeeController@updateResignationStatus');
    }

    public function dispatch()
    {
        $this->router->dispatch();
    }
}
