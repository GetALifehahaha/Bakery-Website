document.addEventListener('DOMContentLoaded', function() {
    
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }

    const logoutBtn = document.querySelector('.logout-btn');
    
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'bkAdminLogin.html';
            }
        });
    }

    
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            alert('Form submitted successfully!');
            form.reset();
        });
    });

    const deleteButtons = document.querySelectorAll('.delete-btn, .action-btn.delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (confirm('Are you sure you want to delete this item?')) {
                const row = this.closest('tr');
                if (row) {
                    row.remove();
                }
            }
        });
    });
});

// Edit Modal Functions
function openEditModal(id, name, position, email, hireDate) {
    document.getElementById('editEmployeeId').value = id;
    document.getElementById('editName').value = name;
    document.getElementById('editPosition').value = position;
    document.getElementById('editEmail').value = email;
    document.getElementById('editHireDate').value = hireDate;
    document.getElementById('editModal').style.display = 'block';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Delete Modal Functions
function openDeleteModal(id, name) {
    document.getElementById('deleteEmployeeName').textContent = name;
    document.getElementById('deleteModal').style.display = 'block';
    // Store ID for deletion
    document.getElementById('deleteModal').dataset.employeeId = id;
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

function deleteEmployee() {
    // Get the employee ID from the dataset
    const employeeId = document.getElementById('deleteModal').dataset.employeeId;
    
    // Here you would normally send an AJAX request to delete the employee
    console.log(`Deleting employee with ID: ${employeeId}`);
    
    // For demo, we'll just remove the row from the table
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        if (row.cells[0].textContent === employeeId) {
            row.remove();
        }
    });
    
    // Close the modal
    closeDeleteModal();
    
    // Show a success message (you could use a toast/notification)
    alert(`Employee with ID ${employeeId} has been deleted.`);
}

// Add Modal Functions
function openAddModal() {
    // Clear the form
    document.getElementById('addForm').reset();
    // Set today's date as default
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('addHireDate').value = today;
    // Show the modal
    document.getElementById('addModal').style.display = 'block';
}

function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
}

// Form submission handlers
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form values
        const id = document.getElementById('editEmployeeId').value;
        const name = document.getElementById('editName').value;
        const position = document.getElementById('editPosition').value;
        const email = document.getElementById('editEmail').value;
        const hireDate = document.getElementById('editHireDate').value;
        
        // Here you would normally send an AJAX request to update the employee
        console.log(`Updating employee with ID: ${id}`);
        console.log({name, position, email, hireDate});
        
        // For demo, we'll update the row in the table
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            if (row.cells[0].textContent === id) {
                row.cells[1].textContent = name;
                row.cells[2].textContent = position;
                row.cells[3].textContent = email;
                row.cells[4].textContent = hireDate;
                
                // Update the onclick handlers for the buttons
                const editBtn = row.querySelector('.edit-btn');
                editBtn.setAttribute('onclick', `openEditModal('${id}', '${name}', '${position}', '${email}', '${hireDate}')`);
                
                const deleteBtn = row.querySelector('.delete-btn');
                deleteBtn.setAttribute('onclick', `openDeleteModal('${id}', '${name}')`);
            }
        });
        
        // Close the modal
        closeEditModal();
        
        // Show a success message (you could use a toast/notification)
        alert(`Employee with ID ${id} has been updated.`);
    });

    document.getElementById('addForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form values
        const id = document.getElementById('addId').value;
        const name = document.getElementById('addName').value;
        const position = document.getElementById('addPosition').value;
        const email = document.getElementById('addEmail').value;
        const hireDate = document.getElementById('addHireDate').value;
        
        // Here you would normally send an AJAX request to add the employee
        console.log(`Adding new employee with ID: ${id}`);
        console.log({name, position, email, hireDate});
        
        // For demo, we'll add a new row to the table
        const table = document.querySelector('tbody');
        const newRow = table.insertRow();
        
        // Add cells
        const idCell = newRow.insertCell(0);
        const nameCell = newRow.insertCell(1);
        const positionCell = newRow.insertCell(2);
        const emailCell = newRow.insertCell(3);
        const hireDateCell = newRow.insertCell(4);
        const actionsCell = newRow.insertCell(5);
        
        // Add content to cells
        idCell.textContent = id;
        nameCell.textContent = name;
        positionCell.textContent = position;
        emailCell.textContent = email;
        hireDateCell.textContent = hireDate;
        
        // Create action buttons
        actionsCell.innerHTML = `
            <div class="action-buttons">
                <button class="edit-btn" onclick="openEditModal('${id}', '${name}', '${position}', '${email}', '${hireDate}')">Edit</button>
                <button class="delete-btn" onclick="openDeleteModal('${id}', '${name}')">Delete</button>
            </div>
        `;
        
        // Close the modal
        closeAddModal();
        
        // Show a success message (you could use a toast/notification)
        alert(`New employee with ID ${id} has been added.`);
    });
});

// Close modal when clicking outside
window.onclick = function(event) {
    const editModal = document.getElementById('editModal');
    const deleteModal = document.getElementById('deleteModal');
    const addModal = document.getElementById('addModal');
    
    if (event.target === editModal) {
        closeEditModal();
    }
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
    if (event.target === addModal) {
        closeAddModal();
    }
};