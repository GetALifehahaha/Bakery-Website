<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employees - BreadKey</title>
    <link rel="stylesheet" href="/styles/employeeStyle.css">
    <script src="/js/employee_js.js"></script>
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
                <a href="employees.php" class="menu-item active">
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

            
        <div class="main-content main-grid">
            <div class="header">
                <h1>Employees</h1>
                <button class="add-employee-btn" onclick="openAddModal()">Add New Employee</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Email</th>
                        <th>Hire Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>EMP001</td>
                        <td>John Baker</td>
                        <td>Head Baker</td>
                        <td>john@bakerykey.com</td>
                        <td>2022-01-15</td>
                        <td>
                            <div class="action-buttons">
                                <button class="edit-btn" onclick="openEditModal('EMP001', 'John Baker', 'Head Baker', 'john@bakerykey.com', '2022-01-15')">Edit</button>
                                <button class="delete-btn" onclick="openDeleteModal('EMP001', 'John Baker')">Delete</button>
                            </div>
                        </td>
                    </tr>
                        
                    <tr>
                        <td>EMP002</td>
                        <td>Sarah Dough</td>
                        <td>Assistant Baker</td>
                        <td>sarah@bakerykey.com</td>
                        <td>2022-03-01</td>
                        <td>
                            <div class="action-buttons">
                                <button class="edit-btn" onclick="openEditModal('EMP002', 'Sarah Dough', 'Assistant Baker', 'sarah@bakerykey.com', '2022-03-01')">Edit</button>
                                <button class="delete-btn" onclick="openDeleteModal('EMP002', 'Sarah Dough')">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>EMP003</td>
                        <td>Mike Flour</td>
                        <td>Sales Manager</td>
                        <td>mike@bakerykey.com</td>
                        <td>2022-05-10</td>
                        <td>
                            <div class="action-buttons">
                                <button class="edit-btn" onclick="openEditModal('EMP003', 'Mike Flour', 'Sales Manager', 'mike@bakerykey.com', '2022-05-10')">Edit</button>
                                <button class="delete-btn" onclick="openDeleteModal('EMP003', 'Mike Flour')">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>EMP004</td>
                        <td>Emma Yeast</td>
                        <td>Customer Service</td>
                        <td>emma@bakerykey.com</td>
                        <td>2022-07-20</td>
                        <td>
                            <div class="action-buttons">
                                <button class="edit-btn" onclick="openEditModal('EMP004', 'Emma Yeast', 'Customer Service', 'emma@bakerykey.com', '2022-07-20')">Edit</button>
                                <button class="delete-btn" onclick="openDeleteModal('EMP004', 'Emma Yeast')">Delete</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>EMP005</td>
                        <td>Tom Oven</td>
                        <td>Delivery Driver</td>
                        <td>tom@bakerykey.com</td>
                        <td>2022-09-05</td>
                        <td>
                            <div class="action-buttons">
                                <button class="edit-btn" onclick="openEditModal('EMP005', 'Tom Oven', 'Delivery Driver', 'tom@bakerykey.com', '2022-09-05')">Edit</button>
                                <button class="delete-btn" onclick="openDeleteModal('EMP005', 'Tom Oven')">Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

     <!-- Edit Employee Modal -->
     <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Employee</h2>
            <form id="editForm">
                <input type="hidden" id="editEmployeeId">
                <div class="form-group">
                    <label for="editName">Name</label>
                    <input type="text" id="editName" required>
                </div>
                <div class="form-group">
                    <label for="editPosition">Position</label>
                    <input type="text" id="editPosition" required>
                </div>
                <div class="form-group">
                    <label for="editEmail">Email</label>
                    <input type="email" id="editEmail" required>
                </div>
                <div class="form-group">
                    <label for="editHireDate">Hire Date</label>
                    <input type="date" id="editHireDate" required>
                </div>
                <div class="form-buttons">
                    <button type="button" class="cancel-btn" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="save-btn">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Employee Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDeleteModal()">&times;</span>
            <h2>Delete Employee</h2>
            <div class="delete-confirmation">
                <p>Are you sure you want to delete <span id="deleteEmployeeName"></span>?</p>
                <p>This action cannot be undone.</p>
                <div>
                    <button class="cancel-delete" onclick="closeDeleteModal()">Cancel</button>
                    <button class="confirm-delete" onclick="deleteEmployee()">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Employee Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddModal()">&times;</span>
            <h2>Add New Employee</h2>
            <form id="addForm">
                <div class="form-group">
                    <label for="addName">Name</label>
                    <input type="text" id="addName" required>
                </div>
                <div class="form-group">
                    <label for="addPosition">Position</label>
                    <input type="text" id="addPosition" required>
                </div>
                <div class="form-group">
                    <label for="addEmail">Email</label>
                    <input type="email" id="addEmail" required>
                </div>
                <div class="form-group">
                    <label for="addHireDate">Hire Date</label>
                    <input type="date" id="addHireDate" required>
                </div>
                <div class="form-buttons">
                    <button type="button" class="cancel-btn" onclick="closeAddModal()">Cancel</button>
                    <button type="submit" class="save-btn">Add Employee</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>