<?php
    include'../class/Database.php';

    $database = new Database();
    $db = $database->getConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products - BreadKey</title>
    <link rel="stylesheet" href="/styles/css.css">
    <script src="/js/products_js.js" defer></script>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="brand">
                <div class="logo">
                    <img src="/assets/logoBK.png" alt="Brand">
                </div>
                <h1>BakeryKey</h1>
            </div>
            
            <div class="admin-profile">
                <div class="profile-img">
                    <img src="/assets/personIcon.png" alt="Admin">
                </div>
                <p class="admin-email">AdminLan</p>
            </div>
            
            <div class="sidebar-menu">
                <a href="bakeryAdmin.php" class="menu-item">
                    <i class="sidebar_menu"></i>
                    <span>Dashboard</span>
                </a>
                <a href="transaction.php" class="menu-item">
                    <i class="transaction"></i>
                    <span>Transaction History</span>
                </a>
                <a href="employees.php" class="menu-item">
                    <i class="employees"></i>
                    <span>Employees</span>
                </a>
                <a href="products.php" class="menu-item active">
                    <i class="products"></i>
                    <span>Products</span>
                </a>
                <a href="customers.php" class="menu-item">
                    <i class="customers"></i>
                    <span>Customers</span>
                </a>
                <a href="about.php" class="menu-item">
                    <i class="about"></i>
                    <span>About</span>
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="top-nav">
                <nav>
                    <ul>
                        <li><a href="bakeryAdmin.html" class="active">Home</a></li>
                    </ul>
                </nav>
                <div class="user-actions">
                    <button class="logout-btn">
                        <i class="logout"></i>
                        Logout
                    </button>
                </div>
            </div>

        <div class="main-content main-grid">
            <div class="header">
                <h1>Products</h1>

                <div class="search-filter">
                    <button class="add-employee-btn" onclick="openAddModal()">Add New Product</button>

                    <input type="text" id="searchBox" placeholder="Search product by name..." onkeyup="filterProducts()">

                    <select id="filterCategory" onchange="filterProducts()">
                        <option value="">Filter By Category</option>
                        <option value="bread">Bread</option>
                        <option value="pastry">Pastry</option>
                        <option value="specials">Specials</option>
                        <option value="drinks">Drinks</option>
                    </select>
                </div>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Product</h2>
            <form id="editForm">
                <input type="hidden" id="editProductID">
                <div class="form-group">
                    <label for="editProductName">Product Name</label>
                    <input type="text" id="editProductName" required>
                </div>
                <div class="form-group">
                    <label for="editDescription">Description</label>
                    <input type="text" id="editDescription" required>
                </div>
                <div class="form-group">
                    <label for="editCategory">Category</label>
                    <select name="editCategory" id="editCategory">
                        <option value="">Select Category</option>
                        <option value="bread">Bread</option>
                        <option value="pastry">Pastry</option>
                        <option value="specials">Specials</option>
                        <option value="drinks">Drinks</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editStockQuantity">Stock Quantity</label>
                    <input type="number" id="editStockQuantity" required>
                </div>
                <div class="form-group">
                    <label for="editProductPrice">Product Price</label>
                    <input type="number" id="editProductPrice" required>
                </div>
                <div class="form-buttons">
                    <button type="button" class="cancel-btn" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="save-btn" onclick="updateProduct()">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddModal()">&times;</span>
            <h2>Add New Product</h2>
            <form id="addForm">
            <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input type="text" id="productName" required>
                </div>
                <div class="form-group">
                    <label for="productDescription">Description</label>
                    <input type="text" id="productDescription" required>
                </div>
                <div class="form-group">
                    <label for="productCategory">Category</label>
                    <select name="productCategory" id="productCategory">
                        <option value="">Select Category</option>
                        <option value="bread">Bread</option>
                        <option value="pastry">Pastry</option>
                        <option value="specials">Specials</option>
                        <option value="drinks">Drinks</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="stockQuantity">Stock Quantity</label>
                    <input type="number" id="stockQuantity" required>
                </div>
                <div class="form-group">
                    <label for="productPrice">Product Price</label>
                    <input type="number" id="productPrice" required>
                </div>
                <div class="form-buttons">
                    <button type="button" class="cancel-btn" onclick="closeAddModal()">Cancel</button>
                    <button type="submit" class="save-btn" onclick="addProduct()">Add Product</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>