<?php 
class Database {
    private $host = "localhost";
    private $db_name = "bakerykey_db";
    private $username = "root";
    private $password = "";
    private $conn;
    
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            error_log("Database connection error: " . $exception->getMessage());
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Database connection error: " . $exception->getMessage()]);
            exit;
        }
        return $this->conn;
    }
}
?>