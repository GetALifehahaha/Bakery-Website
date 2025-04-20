<?php

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type");

    include "../class/Database.php";
    include "../class/Products.php";

    $database = new Database();
    $db = $database->getConnection();

    if (!$db){
        echo json_encode(["status" => "error", "message" => "Failed to connect to database"]);
    }

    $product = new Products($db);

    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method){
        case 'GET':
            if (isset($_GET['id'])){
                $productData = $product->getProductByID($_GET['id']);
                if ($productData){
                    echo json_encode(["status" => "success", "product" => $productData]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Product Not Found"]);
                }
            } else {
                $products =  $product->getAllProducts();
                echo json_encode(["status" => "success", "product" => $products]);
            }
            break;


        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$data){
                echo json_encode(["status" => "error", "message" => "Invalid JSON Input"]);
                exit;
            }

            if (isset($data["product_name"], $data["product_description"], $data["product_category"], $data["stock_quantity"], $data["product_price"])){
                $result = $product->addProduct($data["product_name"], $data["product_description"], $data["product_category"], $data["stock_quantity"], $data["product_price"]);

                if ($result){
                    echo json_encode(["status" => "success", "message" => "Product Added Successfully"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to add product"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid Input"]);

            }
            break;


        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$data){
                echo json_encode(["status" => "error", "message" => "Invalid JSON Input"]);
                exit;
            }

            if (isset($data["product_ID"], $data["product_name"], $data["product_description"], $data["product_category"], $data["stock_quantity"], $data["product_price"])){
                $result = $product->updateProduct($data["product_ID"], $data["product_name"], $data["product_description"], $data["product_category"], $data["stock_quantity"], $data["product_price"]);

                if ($result){
                    echo json_encode(["status" => "success", "message" => "Product updated successfully"]);
                } else {
                    echo json_encode(["status" => "success", "message" => "Failed to update product"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid JSON Input"]);
            }
            break;

        case 'DELETE':
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$data){
                echo json_encode(["status" => "error", "message" => "Invalid JSON Input"]);
                exit;
            }

            if (isset($data["product_ID"])){
                $result = $product->deleteProduct($data["product_ID"]);
                if ($result){
                    echo json_encode(["status" => "success", "message" => "Product Deleted Successfully"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to delete product."]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid ID"]);
            }
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Invalid Request Method"]);
    }
?>