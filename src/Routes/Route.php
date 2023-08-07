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
        // Job
        $this->router->get('/listAllJobPositionByCompany', 'Job/JobController@listAllJobPositionByCompany');
        $this->router->post('/createJobPosition', 'Job/JobController@createJobPosition');

        // Company
        $this->router->get('/listCompanies', 'Company/CompanyController@listCompanies');
        $this->router->post('/createCompany', 'Company/CompanyController@createCompany');
        
        // Employee
        $this->router->get('/listEmployeesByCompany', 'Employee/EmployeeController@listEmployeesByCompany');
        $this->router->get('/listEmployeesByJob', 'Employee/EmployeeController@listEmployeesByJob');
        $this->router->get('/listEmployeesBySalaryRange', 'Employee/EmployeeController@listEmployeesBySalaryRange');
        $this->router->post('/onboardEmployee', 'Employee/EmployeeController@onboardEmployee');
        $this->router->post('/applyResignation', 'Employee/EmployeeController@applyResignation');
        $this->router->post('/updateResignationStatus', 'Employee/EmployeeController@updateResignationStatus');
    }

    public function dispatch()
    {
        $this->router->dispatch();
    }
}
