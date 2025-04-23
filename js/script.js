const apiUrl = '/api/employees_api.php';

// Display message in modal
function showModal(modalId, message, isSuccess = true) {
    const modal = document.getElementById(modalId);
    const messageElement = document.getElementById(modalId + 'Message');
    messageElement.textContent = message;
    modal.style.display = 'block';
}

// Close modal
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

// Open add modal
function openAddModal() {
    document.getElementById('addEmployeeForm').reset();
    document.getElementById('addModal').style.display = 'block';
}

// Fetch and display all employees
async function fetchEmployees() {
    try {
        const response = await fetch(apiUrl);
        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to fetch employees');

        const employeeList = document.getElementById('employeeList');
        employeeList.innerHTML = '';
        
        if (Object.keys(data.data).length === 0) {
            employeeList.innerHTML = '<tr><td colspan="6">No employees found.</td></tr>';
            return;
        }
        
        for (const id in data.data) {
            const emp = data.data[id];
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${emp.employee_ID}</td>
                <td>${emp.employee_name}</td>
                <td>${emp.employee_occupation}</td>
                <td>${emp.phone_number}</td>
                <td>${emp.employee_hire_date}</td>
                <td>
                    <div class="action-buttons">
                        <button class="edit-btn" onclick="updateEmployee(${emp.employee_ID})">Edit</button>
                        <button class="delete-btn" onclick="openDeleteModal(${emp.employee_ID}, '${emp.employee_name}')">Delete</button>
                    </div>
                </td>
            `;
            employeeList.appendChild(row);
        }
    } catch (error) {
        console.error('Error:', error);
        showModal('errorModal', error.message, false);
    }
}

// Add employee
document.getElementById('addEmployeeForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const employee = {
        name: document.getElementById('addName').value.trim(),
        occupation: document.getElementById('addOccupation').value.trim(),
        phone_number: document.getElementById('addPhoneNumber').value.trim(),
        hire_date: document.getElementById('addHireDate').value
    };

    // Client-side validation
    if (!employee.name || !employee.occupation || !employee.phone_number || !employee.hire_date) {
        showModal('errorModal', 'All fields are required', false);
        return;
    }

    // Validate and format phone number (must be exactly 11 digits)
    const rawPhone = employee.phone_number.replace(/\D/g, '');
    if (rawPhone.length === 11) {
        employee.phone_number = rawPhone.replace(/(\d{3})(\d{3})(\d{5})/, '$1-$2-$3');
    } else {
        showModal('errorModal', 'Phone number must be exactly 11 digits.', false);
        return;
    }

    try {
        const response = await fetch(apiUrl, {
            method: 'POST',
            body: JSON.stringify(employee),
            headers: {
                'Content-Type': 'application/json'
            }
        });

        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to add employee');
        showModal('successModal', 'Employee added successfully!');
        closeModal('addModal');
        fetchEmployees();
    } catch (error) {
        console.error('Error:', error);
        showModal('errorModal', error.message, false);
    }
});

// Open delete modal
function openDeleteModal(id, name) {
    document.getElementById('deleteEmployeeName').textContent = name;
    document.getElementById('confirmDeleteBtn').onclick = () => deleteEmployee(id);
    document.getElementById('deleteModal').style.display = 'block';
}

// Delete employee
async function deleteEmployee(id) {
    try {
        console.log(id);
        const response = await fetch(`${apiUrl}?id=${id}`, {
            method: 'DELETE'
        });

        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to delete employee');
        showModal('successModal', 'Employee deleted successfully!');
        closeModal('deleteModal');
        document.getElementById('confirmDeleteBtn').onclick = null;
        fetchEmployees();
    } catch (error) {
        console.error('Error:', error);
        showModal('errorModal', error.message, false);
    }
}

// Show update form modal with pre-filled data
function updateEmployee(id) {
    fetch(`${apiUrl}?id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (!data.success) throw new Error(data.message || 'Failed to fetch employee details');
            const employee = data.data[id];
            document.getElementById('updateId').value = employee.employee_ID;
            document.getElementById('updateName').value = employee.employee_name;
            document.getElementById('updateOccupation').value = employee.employee_occupation;
            document.getElementById('updatePhoneNumber').value = employee.phone_number;
            document.getElementById('updatePhoneNumber').dataset.original = employee.phone_number;
            document.getElementById('updateModal').style.display = 'block';
        })
        .catch(error => {
            console.error(error);
            showModal('errorModal', error.message, false);
        });
}

// Submit update form
document.getElementById('updateEmployeeForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const id = document.getElementById('updateId').value;
    const name = document.getElementById('updateName').value.trim();
    const occupation = document.getElementById('updateOccupation').value.trim();
    const phoneNumberInput = document.getElementById('updatePhoneNumber');
    let phoneNumber = phoneNumberInput.value.trim();
    const originalPhoneNumber = phoneNumberInput.dataset.original;

    // Validation for required fields
    if (!name || !occupation) {
        showModal('errorModal', 'Name and occupation are required', false);
        return;
    }

    // Only validate phone number if it has changed
    const rawInputPhone = phoneNumber.replace(/\D/g, '');
    const rawOriginalPhone = originalPhoneNumber.replace(/\D/g, '');
    if (rawInputPhone !== rawOriginalPhone) {
        if (rawInputPhone.length === 11) {
            phoneNumber = rawInputPhone;
        } else {
            showModal('errorModal', 'The number shouldn\'t be less than or more than 11 digits.', false);
            return;
        }
    } else {
        phoneNumber = rawOriginalPhone;
    }

    try {
        const response = await fetch(`${apiUrl}?id=${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name, occupation, phone_number: phoneNumber })
        });

        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to update employee.');
        showModal('successModal', 'Employee updated successfully!');
        closeModal('updateModal');
        fetchEmployees();
    } catch (error) {
        console.error('Error:', error);
        showModal('errorModal', error.message, false);
    }
});

// Load employees on page load
document.addEventListener('DOMContentLoaded', fetchEmployees);