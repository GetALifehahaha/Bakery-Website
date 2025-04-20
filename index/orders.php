<?php
    include('../Class/Database.php');
    include('../Class/Orders.php');

    $database = new Database();
    $db = $database->getConnection();

    if (!$db){
        echo "Cannot connect to database";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="/js/orders_js.js" defer></script>
</head>
<body>
    <div class="add_order">

        <!-- <input type="number" placeholder="customer, type 1">
        <input type="number" placeholder="employee, type 1">
        <input type="number" placeholder="product, 1-pandesal, 11-strawberry shake, 12-super cheese, 13-strawberry cupcake">
        <input type="number" placeholder="amount">

        <button id="place_order_button">Place Order</button> -->

        <div class="productOrder">
            <button onclick="addOrder()">Proceed With Order</button>
            <table>
                <thead>
                    <tr>
                        <td>Product ID</td>
                        <td>Product Name</td>
                        <td>Product Category</td>
                        <td>Amount</td>
                        <td>Subtotal</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody id="productOrderBody">

                </tbody>
            </table>
        </div>

        <div class="productTable">
            <table>
                <thead>
                    <tr>
                        <td>Product ID</td>
                        <td>Product Name</td>
                        <td>Product Category</td>
                        <td>Stock Quantity</td>
                        <td>Price</td>
                        <td>Action</td>
                    </tr>
                </thead>

                <tbody id="productTableBody">

                </tbody>
            </table>
        </div>
    </div>

    <br>
    <br>
    <br>
    <div class="order_table">
        <table>
            <thead>
                <tr>
                    <td>Order ID</td>
                    <td>Product Name</td>
                    <td>Order Date</td>
                    <td>Total Amount</td>
                    <td>Order Status</td>
                    <td>Customer Name</td>
                    <td>Employee Name</td>
                    <td>Action</td>
                </tr>
            </thead>
    
            <tbody id="orderTableBody">
            </tbody>
        </table>
    </div>
</body>
</html>