<?php

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");
    header("Access-Control-Allow-Headers: Content-Type");

    include('../Class/Database.php');
    include('../Class/DbTest.php');
    include('../Class/Order_Items.php');

    $database = new Database();
    $db = $database->getConnection();

    $test = new DbTest($db);
    $resp = $test->checkConnection();

    // echo json_encode($resp);
    
    $order_item = new Order_Items($db);

    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method){
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$data){
                echo json_encode(["status" => "error", "message" => "Invalid JSON Input"]);
                exit;
            }

            if(isset($data['quantity'], $data['subtotal'], $data['product_ID'], $data['employee_ID'], $data['order_ID'])){
                $result = $order_item->addOrderItem($data['quantity'], $data['subtotal'], $data['order_ID'], $data['product_ID'], $data['employee_ID']);

                if ($result){
                    echo json_encode(["status" => "success", "message" => "Order added successfully"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to add order item"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Missing JSON data"]);
            }
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$data){
                echo json_encode(["status" => "error", "message" => "Invalid JSON Input"]);
                exit;
            }

            if (isset($data['order_ID'])){
                $result = $order_item->returnItem($data['order_ID']);

                if ($result){
                    echo json_encode(["status" => "success", "message" => "Products returned successfully"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to return item"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
            }
            break;
        default:
            echo json_encode(["status" => "error", "message" => "Invalid Request Method"]);
    }
?>