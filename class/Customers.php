<?php
require_once __DIR__ . '/../database/Database.php';

class Customers {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Add a new customer
    public function addCustomer($name, $phoneNumber, $email, $address) {
        if (empty($name) || empty($phoneNumber) || empty($email) || empty($address)) {
            return false;
        }

        // Format phone number
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);

        try {
            $stmt = $this->conn->prepare("
                INSERT INTO customers (name, phone_number, email, address)
                VALUES (:name, :phone_number, :email, :address)
            ");
            $stmt->execute([
                ':name' => $name,
                ':phone_number' => $phoneNumber,
                ':email' => $email,
                ':address' => $address
            ]);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error adding customer: " . $e->getMessage());
            return false;
        }
    }

    // Read single customer by ID
    public function getCustomer($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM customers WHERE customer_ID = :customer_ID");
            $stmt->execute([':customer_ID' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);  // Return as associative array
        } catch (PDOException $e) {
            error_log("Error fetching customer: " . $e->getMessage());
            return null;
        }
    }

    // Read all customers
    public function getAllCustomers() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM customers");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Return as associative array
        } catch (PDOException $e) {
            error_log("Error fetching customers: " . $e->getMessage());
            return [];
        }
    }

    // Update customer
    public function updateCustomer($id, $name = null, $phoneNumber = null, $email = null, $address = null) {
        if (!$this->getCustomer($id)) {
            return false;
        }

        $updates = [];
        $params = [':customer_ID' => $id];

        if ($name) {
            $updates[] = "name = :name";
            $params[':name'] = $name;
        }
        if ($phoneNumber) {
            $updates[] = "phone_number = :phone_number";
            $params[':phone_number'] = $this->formatPhoneNumber($phoneNumber);
        }
        if ($email) {
            $updates[] = "email = :email";
            $params[':email'] = $email;
        }
        if ($address) {
            $updates[] = "address = :address";
            $params[':address'] = $address;
        }

        if (count($updates) > 0) {
            try {
                $stmt = $this->conn->prepare("
                    UPDATE customers 
                    SET " . implode(', ', $updates) . "
                    WHERE customer_ID = :customer_ID
                ");
                $stmt->execute($params);
                return $stmt->rowCount() > 0;
            } catch (PDOException $e) {
                error_log("Error updating customer: " . $e->getMessage());
                return false;
            }
        }
        return false;
    }

    // Delete customer
    public function deleteCustomer($id) {
        if (!$this->getCustomer($id)) {
            return false;
        }

        try {
            $stmt = $this->conn->prepare("DELETE FROM customers WHERE customer_ID = :customer_ID");
            $stmt->execute([':customer_ID' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error deleting customer: " . $e->getMessage());
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