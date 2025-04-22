<?php

    class Orders{

        private $order_ID;
        private $order_date;
        private $total_amount;
        private $order_status;
        private $customer_ID_FK;
        public $conn;
        public $table = 'orders';

        public function __construct($db){
            $this->conn = $db;
        }

        public function createOrder($order_date, $order_status, $total_amount, $customer_ID_FK){
            $query = 'INSERT INTO '.$this->table. ' (order_date, order_status, total_amount, customer_ID_FK) VALUES (?, ?, ?, ?)';
            $stmt = $this->conn->prepare($query);
            $result =  $stmt->execute([$order_date, $order_status, $total_amount, $customer_ID_FK]);

            if ($result){
                return $this->conn->lastInsertID();
            } else {
                return $result;
            }
        }

        public function getAllOrders(){
            $query = 'SELECT o.order_ID order_ID, p.product_ID product_ID , GROUP_CONCAT(p.product_name SEPARATOR "\n") product_name, o.order_date order_date, GROUP_CONCAT(oi.quantity SEPARATOR "\n") quantity, GROUP_CONCAT("₱ ", oi.subtotal SEPARATOR "\n") subtotal, SUM(oi.subtotal) total_amount, o.order_status, c.name customer_name, e.employee_name employee_name FROM '.$this->table. ' o JOIN orderitems oi ON oi.order_ID_FK = o.order_ID JOIN products p ON p.product_ID = oi.product_ID_FK JOIN customers c ON c.customer_ID = o.customer_ID_FK JOIN employees e ON e.employee_ID = oi.employee_ID_FK ORDER BY o.order_ID DESC';
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function updateOrder($status, $order_ID){
            $query = 'UPDATE '.$this->table. ' SET order_status = ? WHERE order_ID = ?';
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$status, $order_ID]);
        }
    }

?>