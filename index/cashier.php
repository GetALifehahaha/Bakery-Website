<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BakeryKey - Cashier</title>
    <script src="/js/cashier_js.js"></script>
    <link rel="stylesheet" href="/styles/cashier.css">
</head>
<body>
    <div class="top-header">
            <div class="brand">
                <div class="logo">
                    <img src="/assets/logoBK.png" alt="Brand">
                </div>
                <h1>BakeryKey</h1>
            </div>
        <button class="logout-btn" id="logoutBtn">Logout</button>
    </div>
    
    <div class="main-content">
        <div class="main-header">
            <h1 class="page-title">Cashier</h1>
            
            <button class="proceed-btn" id="proceedBtn" onclick="addOrder()">Proceed With Order</button>
        </div>
        
        <div class="cashier-area">
            <div class="cart-section">
                <h2 class="section-title">Current Order</h2>
                <div class="total-section">
                    Total: ₱ <span id="cartTotal">0.00</span>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Amount</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="cartTableBody">
                        
                    </tbody>
                </table>
                
            </div>
            
            <div class="inventory-section">
                <div class="inventory-header">
                    <h2 class="section-title">Available Products</h2>

                    <div class="search-filter">
                    <input type="text" id="searchBox" placeholder="Search product" onkeyup="filterProducts()">

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
                    <table >
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Product Category</th>
                                <th>Stock Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
    
                        <tbody id="productTableBody">
                            <!-- Inventory items will be dynamically added here -->
                        </tbody>
    
                    </table>
                </div>
            </div>
        </div>
        
        <!-- <div class="order-section">
            <h2 class="section-title">Current Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Order Status</th>
                        <th>Customer Name</th>
                        <th>Employee Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody">
                </tbody>
            </table>
        </div> -->
    </div>
    
    <!-- Confirmation Modal -->
    <div class="modal" id="confirmModal">
        <div class="modal-content">
            <div class="modal-title">Confirm Order</div>
            <p>Are you sure you want to proceed with this order?</p>
            <div class="modal-buttons">
                <button class="modal-btn modal-btn-cancel" id="cancelOrderBtn">Cancel</button>
                <button class="modal-btn modal-btn-confirm" id="confirmOrderBtn">Confirm</button>
            </div>
        </div>
    </div>
    
    <!-- Logout Confirmation Modal -->
    <div class="modal" id="logoutModal">
        <div class="modal-content">
            <div class="modal-title">Confirm Logout</div>
            <p>Are you sure you want to logout?</p>
            <div class="modal-buttons">
                <button class="modal-btn modal-btn-cancel" id="cancelLogoutBtn">Cancel</button>
                <button class="modal-btn modal-btn-confirm" id="confirmLogoutBtn">Logout</button>
            </div>
        </div>
    </div>
    
</body>
</html>