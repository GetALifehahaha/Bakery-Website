<?php

    class DbTest{
        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }

        public function checkConnection(){
            if ($this->conn){
                return ["status" => "success", "message" => "Database Connected Successfully"];
            } else {
                return ["status" => "error", "message" => "Failed to Connect to Database"];
            }
        }
    }
?>