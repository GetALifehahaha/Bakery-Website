// scripts.js
const apiUrl = 'api/employees_api.php';

// Display message in modal
function showModal(modalId, message, isSuccess = true) {
    const modal = document.getElementById(modalId);
    const messageElement = document.getElementById(modalId + 'Message');
    messageElement.textContent = message;

    const modalClass = isSuccess ? 'success' : 'error';
    modal.classList.add(modalClass);
    modal.style.display = 'flex';
}

// Close modal
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
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
            employeeList.innerHTML = '<p>No employees found.</p>';
            return;
        }
        
        for (const id in data.data) {
            const emp = data.data[id];
            const div = document.createElement('div');
            div.className = 'employee';
            div.innerHTML = `
                <strong>ID: ${emp.employee_ID}</strong><br>
                Name: ${emp.employee_name}<br>
                Occupation: ${emp.employee_occupation}<br>
                Phone: ${emp.phone_number}<br>
                Hire Date: ${emp.employee_hire_date}
                <br>
                <button onclick="updateEmployee(${emp.employee_ID})">Update</button>
                <button onclick="deleteEmployee(${emp.employee_ID})">Delete</button>
            `;
            employeeList.appendChild(div);
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
        name: document.getElementById('name').value.trim(),
        occupation: document.getElementById('occupation').value.trim(),
        phone_number: document.getElementById('phoneNumber').value.trim(),
        hire_date: document.getElementById('hireDate').value
    };

    // Client-side validation
    if (!employee.name || !employee.occupation || !employee.phone_number || !employee.hire_date) {
        showModal('errorModal', 'All fields are required', false);
        return;
    }

    // Validate and format phone number (must be exactly 11 digits)
const rawPhone = employee.phone_number.replace(/\D/g, ''); // Remove non-digits

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
        fetchEmployees(); // Reload employee list
    } catch (error) {
        console.error('Error:', error);
        showModal('errorModal', error.message, false);
    }
});

// Delete employee
async function deleteEmployee(id) {
    const confirmDelete = confirm('Are you sure you want to delete this employee?');
    if (!confirmDelete) return;

    try {
        const response = await fetch(`${apiUrl}?id=${id}`, {
            method: 'DELETE'
        });

        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to delete employee');
        showModal('successModal', 'Employee deleted successfully!');
        fetchEmployees(); // Reload employee list
    } catch (error) {
        console.error('Error:', error);
        showModal('errorModal', error.message, false);
    }
}

// Show update form modal with pre-filled data
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
            // Store the original phone number as a data attribute for comparison
            document.getElementById('updatePhoneNumber').dataset.original = employee.phone_number;
            document.getElementById('updateModal').style.display = 'flex';
        })
        .catch(error => {
            console.error(error);
            showModal('errorModal', error.message, false);
        });
}
// Submit update form
// Submit update form
document.getElementById('updateEmployeeForm').addEventListener('submit', async function (e) {
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
    const rawInputPhone = phoneNumber.replace(/\D/g, ''); // Clean input for comparison
    const rawOriginalPhone = originalPhoneNumber.replace(/\D/g, ''); // Clean original for comparison
    if (rawInputPhone !== rawOriginalPhone) {
        if (rawInputPhone.length === 11) {
            phoneNumber = rawInputPhone; // Keep raw 11-digit number without dashes
        } else {
            showModal('errorModal', 'The number shouldn\'t be less than or more than 11 digits.', false);
            return;
        }
    } else {
        phoneNumber = rawOriginalPhone; // Use raw digits for unchanged number
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
        fetchEmployees(); // Refresh list
    } catch (error) {
        console.error('Error:', error);
        showModal('errorModal', error.message, false);
    }
});


