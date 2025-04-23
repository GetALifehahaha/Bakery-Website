<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers - BreadKey</title>
    <link rel="stylesheet" href="/styles/css.css">
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
                        <li><a href="bakeryAdmin.php" class="active">Home</a></li>
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
                        <input type="text" id="searchBox" placeholder="Search customer by name..." onkeyup="filterCustomers()">
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="customerTableBody">
                        <!-- Customers will be dynamically loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Customer Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addModal')">×</span>
            <h2>Add New Customer</h2>
            <form id="addCustomerForm">
                <div class="form-group">
                    <label for="addName">Name</label>
                    <input type="text" id="addName" required>
                </div>
                <div class="form-group">
                    <label for="addPhoneNumber">Phone (xxx-xxx-xxxx)</label>
                    <input type="text" id="addPhoneNumber" required>
                </div>
                <div class="form-group">
                    <label for="addEmail">Email</label>
                    <input type="email" id="addEmail" required>
                </div>
                <div class="form-group">
                    <label for="addAddress">Address</label>
                    <input type="text" id="addAddress" required>
                </div>
                <div class="form-buttons">
                    <button type="button" class="cancel-btn" onclick="closeModal('addModal')">Cancel</button>
                    <button type="submit" class="save-btn">Add Customer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Customer Modal -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('updateModal')">×</span>
            <h2>Edit Customer</h2>
            <form id="updateCustomerForm">
                <input type="hidden" id="updateId">
                <div class="form-group">
                    <label for="updateName">Name</label>
                    <input type="text" id="updateName" required>
                </div>
                <div class="form-group">
                    <label for="updatePhoneNumber">Phone (xxx-xxx-xxxx)</label>
                    <input type="text" id="updatePhoneNumber" required>
                </div>
                <div class="form-group">
                    <label for="updateEmail">Email</label>
                    <input type="email" id="updateEmail" required>
                </div>
                <div class="form-group">
                    <label for="updateAddress">Address</label>
                    <input type="text" id="updateAddress" required>
                </div>
                <div class="form-buttons">
                    <button type="button" class="cancel-btn" onclick="closeModal('updateModal')">Cancel</button>
                    <button type="submit" class="save-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Customer Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteModal')">×</span>
            <h2>Delete Customer</h2>
            <div class="delete-confirmation">
                <p>Are you sure you want to delete <span id="deleteCustomerName"></span>?</p>
                <p>This action cannot be undone.</p>
                <div>
                    <button class="cancel-delete" onclick="closeModal('deleteModal')">Cancel</button>
                    <button class="confirm-delete" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('successModal')">×</span>
            <h2>Success</h2>
            <p id="successModalMessage"></p>
            <div class="form-buttons">
                <button class="save-btn" onclick="closeModal('successModal')">Close</button>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('errorModal')">×</span>
            <h2>Error</h2>
            <p id="errorModalMessage"></p>
            <div class="form-buttons">
                <button class="cancel-btn" onclick="closeModal('errorModal')">Close</button>
            </div>
        </div>
    </div>

    <script src="/js/customers_js.js"></script>
</body>
</html>