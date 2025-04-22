<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction History - BreadKey</title>
    <link rel="stylesheet" href="/styles/css.css">
    <script src="/js/orders_js.js" defer></script>
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
                <a href="transaction.php" class="menu-item active">
                    <i class="transaction"></i>
                    <span>Transaction History</span>
                </a>
                <a href="employees.php" class="menu-item">
                    <i class="employees"></i>
                    <span>Employees</span>
                </a>
                <a href="products.php" class="menu-item">
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

        <div class="main-content main-grid" id="transactionTable">

            <div class="header">
                <h1>Transaction History</h1>

                <div class="search-filter">
                    <input type="date" id="searchBox" onchange="filterOrders()">

                    <select id="filterStatus" onchange="filterOrders()">
                        <option value="">Filter By Status</option>
                        <option value="in progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Total Amount</th>
                        <th>Employee</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                </tbody>
            </table>
        </div>
    </div>

    <script src="js.js"></script>
</body>
</html>