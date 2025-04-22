<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BreadKey - Dashboard</title>
    <link rel="stylesheet" href="/styles/css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                <a href="bakeryAdmin.php" class="menu-item active">
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

            <div class="content">
                <h2 class="page-title">Dashboard</h2>
                
                <div class="dashboard-cards">
                    <div class="card">
                        <div class="card-icon sales">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="card-info">
                            <h3>Total Sales</h3>
                            <p class="card-value">$85,420</p>
                            <p class="card-change positive">+5.6% <span>from last month</span></p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-icon orders">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="card-info">
                            <h3>Orders</h3>
                            <p class="card-value">1,823</p>
                            <p class="card-change positive">+2.4% <span>from last month</span></p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-icon customers">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-info">
                            <h3>Customers</h3>
                            <p class="card-value">326</p>
                            <p class="card-change positive">+8.2% <span>from last month</span></p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-icon products">
                            <i class="fas fa-bread-slice"></i>
                        </div>
                        <div class="card-info">
                            <h3>Products</h3>
                            <p class="card-value">48</p>
                            <p class="card-change neutral">+0% <span>from last month</span></p>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard-tables">
                    <div class="table-container">
                        <div class="table-header">
                            <h3>Recent Transactions</h3>
                            <a href="transaction.html" class="view-all">View All</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#ORD-8924</td>
                                    <td>Sarah Johnson</td>
                                    <td>Mar 22, 2025</td>
                                    <td>$124.00</td>
                                    <td><span class="status completed">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>#ORD-8923</td>
                                    <td>Mike Williams</td>
                                    <td>Mar 22, 2025</td>
                                    <td>$76.50</td>
                                    <td><span class="status completed">Completed</span></td>
                                </tr>
                                <tr>
                                    <td>#ORD-8922</td>
                                    <td>Emily Davis</td>
                                    <td>Mar 21, 2025</td>
                                    <td>$246.75</td>
                                    <td><span class="status processing">Processing</span></td>
                                </tr>
                                <tr>
                                    <td>#ORD-8921</td>
                                    <td>Robert Brown</td>
                                    <td>Mar 21, 2025</td>
                                    <td>$89.25</td>
                                    <td><span class="status processing">Processing</span></td>
                                </tr>
                                <tr>
                                    <td>#ORD-8920</td>
                                    <td>Jennifer Miller</td>
                                    <td>Mar 20, 2025</td>
                                    <td>$156.00</td>
                                    <td><span class="status cancelled">Cancelled</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="table-container">
                        <div class="table-header">
                            <h3>Top Selling Products</h3>
                            <a href="products.html" class="view-all">View All</a>
                        </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Sales</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sourdough Bread</td>
                                    <td>$7.99</td>
                                    <td>482</td>
                                    <td><span class="stock in-stock">In Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Whole Wheat Bread</td>
                                    <td>$5.99</td>
                                    <td>418</td>
                                    <td><span class="stock in-stock">In Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Baguette</td>
                                    <td>$4.50</td>
                                    <td>376</td>
                                    <td><span class="stock low-stock">Low Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Croissant</td>
                                    <td>$3.25</td>
                                    <td>352</td>
                                    <td><span class="stock in-stock">In Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Cinnamon Roll</td>
                                    <td>$4.75</td>
                                    <td>315</td>
                                    <td><span class="stock out-of-stock">Out of Stock</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 BakeryKey. All rights reserved</p>
    </footer>

    <script src="js.js"></script>
</body>
</html>