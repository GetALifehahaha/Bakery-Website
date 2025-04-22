<?php
require_once __DIR__ . '/../database/Database.php';

class Employees {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Add a new employee
    public function addEmployee($name, $occupation, $phoneNumber, $hireDate) {
        if (empty($name) || empty($occupation) || empty($phoneNumber) || empty($hireDate)) {
            return false;
        }

        // Format phone number
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);

        try {
            $stmt = $this->conn->prepare("
                INSERT INTO employees (employee_name, employee_occupation, phone_number, employee_hire_date)
                VALUES (:employee_name, :employee_occupation, :phone_number, :employee_hire_date)
            ");
            $stmt->execute([
                ':employee_name' => $name,
                ':employee_occupation' => $occupation,
                ':phone_number' => $phoneNumber,
                ':employee_hire_date' => $hireDate
            ]);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error adding employee: " . $e->getMessage());
            return false;
        }
    }

    // Read single employee by ID
    public function getEmployee($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM employees WHERE employee_ID = :employee_ID");
            $stmt->execute([':employee_ID' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);  // Return as associative array
        } catch (PDOException $e) {
            error_log("Error fetching employee: " . $e->getMessage());
            return null;
        }
    }

    // Read all employees
    public function getAllEmployees() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM employees");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Return as associative array
        } catch (PDOException $e) {
            error_log("Error fetching employees: " . $e->getMessage());
            return [];
        }
    }

    // Update employee
    public function updateEmployee($id, $name = null, $occupation = null, $phoneNumber = null, $hireDate = null) {
        if (!$this->getEmployee($id)) {
            return false;
        }

        $updates = [];
        $params = [':employee_ID' => $id];

        if ($name) {
            $updates[] = "employee_name = :employee_name";
            $params[':employee_name'] = $name;
        }
        if ($occupation) {
            $updates[] = "employee_occupation = :employee_occupation";
            $params[':employee_occupation'] = $occupation;
        }
        if ($phoneNumber) {
            $updates[] = "phone_number = :phone_number";
            $params[':phone_number'] = $this->formatPhoneNumber($phoneNumber);
        }
        if ($hireDate) {
            $updates[] = "employee_hire_date = :employee_hire_date";
            $params[':employee_hire_date'] = $hireDate;
        }

        if (count($updates) > 0) {
            try {
                $stmt = $this->conn->prepare("
                    UPDATE employees 
                    SET " . implode(', ', $updates) . "
                    WHERE employee_ID = :employee_ID
                ");
                $stmt->execute($params);
                return $stmt->rowCount() > 0;
            } catch (PDOException $e) {
                error_log("Error updating employee: " . $e->getMessage());
                return false;
            }
        }
        return false;
    }

    // Delete employee
    public function deleteEmployee($id) {
        if (!$this->getEmployee($id)) {
            return false;
        }

        try {
            $stmt = $this->conn->prepare("DELETE FROM employees WHERE employee_ID = :employee_ID");
            $stmt->execute([':employee_ID' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error deleting employee: " . $e->getMessage());
            return false;
        }
    }

    // Helper function to format phone number
    private function formatPhoneNumber($phoneNumber) {
        $rawPhone = preg_replace('/[^0-9]/', '', $phoneNumber);
        if (strlen($rawPhone) !== 11) {
            throw new Exception("The number shouldn't be less than or more than 11 digits.");
        }
        return $rawPhone; // Return raw 11-digit number without dashes
}
}
?>
