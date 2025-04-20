<?php

    class Order_Items{

        public $table = 'orderitems';
        public $product_table = 'products';
        public $order_table = 'orders';
        public $conn;

        public function __construct($db){
            $this->conn = $db;
        }

        public function addOrderItem($quantity, $subtotal, $order_ID_FK, $product_ID_FK, $employee_ID_FK){
            $query = 'UPDATE ' .$this->product_table. ' SET stock_quantity = ((SELECT stock_quantity FROM '.$this->product_table.' WHERE product_ID = ?) - ?) WHERE product_ID = ?';
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([$product_ID_FK, $quantity, $product_ID_FK]);

            if ($result){
                $query = 'INSERT INTO '.$this->table.' (quantity, subtotal, order_ID_FK, product_ID_FK, employee_ID_FK) VALUES (?, ?, ?, ?, ?)';
                $stmt = $this->conn->prepare($query);
                return $stmt->execute([$quantity, $subtotal, $order_ID_FK, $product_ID_FK, $employee_ID_FK]);
            }
        }

        public function returnItem($order_ID){
            $query = 'UPDATE '.$this->product_table. ' p JOIN '.$this->table. ' oi ON oi.product_ID_FK = p.product_ID JOIN '.$this->order_table.' o ON oi.order_ID_FK = o.order_ID SET p.stock_quantity = p.stock_quantity + oi.quantity WHERE o.order_ID = ?';
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$order_ID]);
        }

        
    }
?>