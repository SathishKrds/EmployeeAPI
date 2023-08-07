<?php
namespace Models\Company;

use Config\Database;

class Company
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
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