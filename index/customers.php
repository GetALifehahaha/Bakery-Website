<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers - BreadKey</title>
    <link rel="stylesheet" href="/styles/css.css">
    <script src="/js/customers_js.js"></script>
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
                <a href="products.php" class="menu-item">
                    <i class="products"></i>
                    <span>Products</span>
                </a>
                <a href="customers.php" class="menu-item active">
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
                <h1>Customers</h1>

                <div class="search-filter">
                    <button class="add-employee-btn" onclick="openAddModal()">Add New Customer</button>

                    <input type="text" id="searchBox" placeholder="Search customer by name..." onkeyup="filterProducts()">
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Total Purchases</th>
                        <th>Last Purchase</th>
                    </tr>
                </thead>
                <tbody id="customerTableBody">
                    <tr>
                        <td>CUST001</td>
                        <td>Alice Johnson</td>
                        <td>alice@email.com</td>
                        <td>$456.75</td>
                        <td>2025-03-24</td>
                    </tr>
                    <tr>
                        <td>CUST002</td>
                        <td>Bob Smith</td>
                        <td>bob@email.com</td>
                        <td>$324.50</td>
                        <td>2025-03-22</td>
                    </tr>
                    <tr>
                        <td>CUST003</td>
                        <td>Carol Williams</td>
                        <td>carol@email.com</td>
                        <td>$678.25</td>
                        <td>2025-03-20</td>
                    </tr>
                    <tr>
                        <td>CUST004</td>
                        <td>David Brown</td>
                        <td>david@email.com</td>
                        <td>$245.60</td>
                        <td>2025-03-18</td>
                    </tr>
                    <tr>
                        <td>CUST005</td>
                        <td>Eve Davis</td>
                        <td>eve@email.com</td>
                        <td>$532.40</td>
                        <td>2025-03-15</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="js.js"></script>
</body>
</html>