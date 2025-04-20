<?php

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");
    header("Access-Control-Allow-Headers: Content-Type");

    include('../Class/Database.php');
    include('../Class/DbTest.php');
    include('../Class/Orders.php');

    $database = new Database();
    $db = $database->getConnection();

    $test = new DbTest($db);
    $resp = $test->checkConnection();

    $order = new Orders($db);

    $method = $_SERVER['REQUEST_METHOD'];

    // $result = $order->createOrder('2025-04-17', 'in progress', 100, 1);
    // echo $result;
    // exit;

    switch($method){
        case 'GET':
            $orders = $order->getAllOrders();
            echo json_encode(["status" => "success", "orders" => $orders]);
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data){
                echo json_encode(["status" => "error", "message" => "Invalid JSON Input"]);
                exit;
            }

            if (isset($data['order_date'], $data['total_amount'], $data['order_status'], $data['customer_ID'])){
                $result = $order->createOrder($data['order_date'], $data['order_status'], $data['total_amount'], $data['customer_ID']);

                if ($result){
                    echo json_encode(["status" => "success", "order_ID" => $result]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to add new order"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Incomplete JSON data"]);
            }
            break;
        
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data){
                echo json_encode(["status" => "error", "message" => "Invalid JSON Input"]);
                exit;
            }

            if (isset($data['order_ID'], $data['status'])){
                $result = $order->updateOrder($data['status'], $data['order_ID']);

                if ($result && $data['status'] == "completed"){
                    echo json_encode(["status" => "success", "message" => "Order updated [COMPLETED] successfully"]);
                } else if ($result && $data['status'] == "cancelled"){
                    echo json_encode(["status" => "success", "message" => "Order updated [CANCELLED] successfully"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to update order"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Incomplete JSON data"]);
            }

            break;
        default:
            echo json_encode(["status" => "error", "message" => "Invalid Request Method"]);
    }

?>