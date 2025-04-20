<?php

    class Products{
        public $conn;
        private $table = 'products';

        public function __construct($db){
            $this->conn = $db;
        }

        public function getAllProducts(){
            $query = "SELECT product_ID, product_name, product_description, product_category, stock_quantity, product_price FROM ". $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getProductByID($id){
            $query = "SELECT product_ID, product_name, product_description, product_category, stock_quantity, product_price FROM " . $this->table . " WHERE product_ID = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function addProduct($product_name, $product_description, $product_category, $stock_quantity, $product_price){
            $query = "INSERT INTO ".$this->table. " VALUES (DEFAULT, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$product_name, $product_description, $product_category, $stock_quantity, $product_price]);
        }

        public function updateProduct($product_ID, $product_name, $product_description, $product_category, $stock_quantity, $product_price){
            $query = "UPDATE ".$this->table." SET product_name = ?, product_description = ?, product_category = ?, stock_quantity = ?, product_price = ? WHERE product_ID = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$product_name, $product_description, $product_category, $stock_quantity, $product_price, $product_ID]);
        }

        public function deleteProduct($product_ID){
            $query = "DELETE FROM ".$this->table. " WHERE product_ID = ?"; 
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$product_ID]);
        }
    }
?>