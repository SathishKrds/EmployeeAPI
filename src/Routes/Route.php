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
        $this->router->get('/jobPosition', 'Company/CompanyController@listAllJobPositionByCompany');
        // $this->router->get('/employee', 'Employee/EmployeeController@listAllEmployees');
        $this->router->get('/listCompanies', 'Company/CompanyController@listCompanies');
        $this->router->post('/createCompany', 'Company/CompanyController@createCompany');
        $this->router->post('/createJobPosition', 'Company/CompanyController@createJobPosition');
        $this->router->post('/onboardEmployee', 'Employee/EmployeeController@onboardEmployee');
    }

    public function dispatch()
    {
        $this->router->dispatch();
    }
}
