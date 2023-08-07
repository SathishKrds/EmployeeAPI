<?php
namespace Models\Company;

use Config\Database;

class Company
{
    private $pdo;

    public function __construct()
    {
        $config = Database::getConfig();
        $dsn = "mysql:host={$config['host']};dbname={$config['database']}";
        $this->pdo = new \PDO($dsn, $config['username'], $config['password']);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    // Function to create a new company
    public function createCompany($name, $address, $domain) {
        $query = "INSERT INTO emp_companies (name, address, domain) VALUES ('$name', '$address', '$domain')";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return 'New company created!';
    }

    // Function to get all companies
    public function getCompanies() {
        $query = "SELECT * FROM emp_companies";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>