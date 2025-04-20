<?php
    include '../class/Database.php';
    include '../class/DbTest.php';

    $database = new Database();
    $db = $database->getConnection();

    $test = new DbTest($db);
    $connectionStatus = $test->checkConnection();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <script src="/js/script.js" defer></script>
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
    <div class="header">
        <div class="navbar">
            <button class="menu-toggle" id="menu-toggle">&#9776;</button>
            <div class="logo">Product Management</div>
            <ul class="menu">
                <li><a href="#">Products</a></li>
                <li><a href="#">Transaction History</a></li>
                <li><a href="#">Employees</a></li>
            </ul>
        </div>
    </div>

    <div class="status-container">
        Database Connection Status:
        <span class="status <?= $connectionStatus['status'] === 'success' ? 'success' : 'error' ?>">
            <?= $connectionStatus['message'] ?>
        </span>
    </div>

    <div class="container">
        <div class="table-container">
            <div class="page-header">
                <div class="page-title">Products List</div>
                <button class="add-btn" onclick="openAddProductModal()">Add Product</button>
            </div>

            <div class="search-filter">
                <input type="text" id="searchBox" placeholder="Search product by name..." onkeyup="filterProducts()">

                <select id="filterCategory" onchange="filterProducts()">
                    <option value="">Filter By Category</option>
                    <option value="bread">Bread</option>
                    <option value="pastry">Pastry</option>
                    <option value="specials">Specials</option>
                    <option value="drinks">Drinks</option>
                </select>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Desciption</th>
                        <th>Category</th>
                        <th>Stock Quantity</th>
                        <th>Price</th>
                        <th>Actions</th>
                        
                    </tr>
                </thead>
                <tbody id="productTableBody">

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" id="addProductModal">
        <div id="form">
            <label for="product_name">Product Name</label>
            <input type="text" id="product_name" placeholder="What should I call this product" required>
            <label for="product_description">Description</label>
            <input type="textarea" id="product_description" placeholder="Add a bit of spice">
            <label for="product_category">Category</label>
            <select name="product_category" id="product_category">
                <option value="">Select Category</option>
                <option value="bread">Bread</option>
                <option value="pastry">Pastry</option>
                <option value="specials">Specials</option>
                <option value="drinks">Drinks</option>
            </select>
            <label for="stock_quantity">Stock Quantity</label>
            <input type="text" id="stock_quantity" placeholder="How many do you have?">
            <label for="product_price">Price</label>
            <input type="text" id="product_price" placeholder="How much for each?">

            <button id="add-product-btn" onclick="addProduct()">Add Product</button>
            <button id="cls-btn" onclick="closeAddProductModal()">Cancel</button>
        </div>
    </div>

    <div class="modal" id="editModal">
        <div id="form">
        <label for="edit_product_name">Product Name</label>
            <input type="hidden" name="edit_product_ID" id="edit_product_ID">
            <input type="text" id="edit_product_name" placeholder="What should I call this product" required>
            <label for="edit_product_description">Description</label>
            <input type="textarea" id="edit_product_description" placeholder="Add a bit of spice">
            <label for="edit_product_category">Category</label>
            <select name="edit_product_category" id="edit_product_category">
                <option value="">Select Category</option>
                <option value="bread">Bread</option>
                <option value="pastry">Pastry</option>
                <option value="specials">Specials</option>
                <option value="drinks">Drinks</option>
            </select>
            <label for="edit_stock_quantity">Stock Quantity</label>
            <input type="text" id="edit_stock_quantity" placeholder="How many do you have?">
            <label for="edit_product_price">Price</label>
            <input type="text" id="edit_product_price" placeholder="How much for each?">

            <button id="edit-product-btn" onclick="updateProduct()">Update Product</button>
            <button id="cls-btn" onclick="closeEditModal()">Cancel</button>
        </div>
    </div>
</body>
</html>