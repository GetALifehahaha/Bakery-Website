const apiUrl = '/api/customers_api.php';

let allCustomers = []; // Store all customers for filtering

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
    document.getElementById('addCustomerForm').reset();
    document.getElementById('addModal').style.display = 'block';
}

// Fetch and display all customers
async function fetchCustomers() {
    try {
        const response = await fetch(apiUrl);
        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to fetch customers');

        allCustomers = Object.values(data.data); // Store for filtering
        const customerTableBody = document.getElementById('customerTableBody');
        customerTableBody.innerHTML = '';

        if (allCustomers.length === 0) {
            customerTableBody.innerHTML = '<tr><td colspan="6">No customers found.</td></tr>';
            return;
        }

        renderCustomers(allCustomers);
    } catch (error) {
        console.error('Error:', error);
        showModal('errorModal', error.message, false);
    }
}

// Render customers to table
function renderCustomers(customers) {
    const customerTableBody = document.getElementById('customerTableBody');
    customerTableBody.innerHTML = '';

    console.log("this worked")

    customers.forEach(cust => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${cust.customer_ID}</td>
            <td>${cust.name}</td>
            <td>${cust.phone_number}</td>
            <td>${cust.email}</td>
            <td>${cust.address}</td>
            <td>
                <div class="action-buttons">
                    <button class="edit-btn" onclick="updateCustomer(${cust.customer_ID})">Edit</button>
                    <button class="delete-btn" onclick="openDeleteModal(${cust.customer_ID}, '${cust.name}')">Delete</button>
                </div>
            </td>
        `;
        customerTableBody.appendChild(row);
    });
}

// Filter customers by name
function filterCustomers() {
    const searchTerm = document.getElementById('searchBox').value.toLowerCase();
    const filteredCustomers = allCustomers.filter(cust =>
        cust.name.toLowerCase().includes(searchTerm)
    );
    renderCustomers(filteredCustomers);
}

// Add customer
document.getElementById('addCustomerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const customer = {
        name: document.getElementById('addName').value.trim(),
        phone_number: document.getElementById('addPhoneNumber').value.trim(),
        email: document.getElementById('addEmail').value.trim(),
        address: document.getElementById('addAddress').value.trim()
    };

    // Client-side validation
    if (!customer.name || !customer.phone_number || !customer.email || !customer.address) {
        showModal('errorModal', 'All fields are required', false);
        return;
    }

    // Validate and format phone number (must be exactly 11 digits)
    const rawPhone = customer.phone_number.replace(/\D/g, '');
    if (rawPhone.length === 11) {
        customer.phone_number = rawPhone.replace(/(\d{3})(\d{3})(\d{5})/, '$1-$2-$3');
    } else {
        showModal('errorModal', 'Phone number must be exactly 11 digits.', false);
        return;
    }

    try {
        const response = await fetch(apiUrl, {
            method: 'POST',
            body: JSON.stringify(customer),
            headers: {
                'Content-Type': 'application/json'
            }
        });

        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to add customer');
        showModal('successModal', 'Customer added successfully!');
        closeModal('addModal');
        fetchCustomers();
    } catch (error) {
        console.error('Error:', error);
        showModal('errorModal', error.message, false);
    }
});

// Open delete modal
function openDeleteModal(id, name) {
    document.getElementById('deleteCustomerName').textContent = name;
    document.getElementById('confirmDeleteBtn').onclick = () => deleteCustomer(id);
    document.getElementById('deleteModal').style.display = 'block';
}

// Delete customer
async function deleteCustomer(id) {
    try {
        const response = await fetch(`${apiUrl}?id=${id}`, {
            method: 'DELETE'
        });

        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to delete customer');
        showModal('successModal', 'Customer deleted successfully!');
        closeModal('deleteModal');
        document.getElementById('confirmDeleteBtn').onclick = null;
        fetchCustomers();
    } catch (error) {
        console.error('Error:', error);
        showModal('errorModal', error.message, false);
    }
}

// Show update form modal with pre-filled data
function updateCustomer(id) {
    fetch(`${apiUrl}?id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (!data.success) throw new Error(data.message || 'Failed to fetch customer details');
            const customer = data.data[id];
            document.getElementById('updateId').value = customer.customer_ID;
            document.getElementById('updateName').value = customer.name;
            document.getElementById('updatePhoneNumber').value = customer.phone_number;
            document.getElementById('updateEmail').value = customer.email;
            document.getElementById('updateAddress').value = customer.address;
            document.getElementById('updatePhoneNumber').dataset.original = customer.phone_number;
            document.getElementById('updateModal').style.display = 'block';
        })
        .catch(error => {
            console.error(error);
            showModal('errorModal', error.message, false);
        });
}

// Submit update form
document.getElementById('updateCustomerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const id = document.getElementById('updateId').value;
    const name = document.getElementById('updateName').value.trim();
    const phoneNumberInput = document.getElementById('updatePhoneNumber');
    let phoneNumber = phoneNumberInput.value.trim();
    const email = document.getElementById('updateEmail').value.trim();
    const address = document.getElementById('updateAddress').value.trim();
    const originalPhoneNumber = phoneNumberInput.dataset.original;

    // Validation for required fields
    if (!name || !phoneNumber || !email || !address) {
        showModal('errorModal', 'All fields are required', false);
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
            body: JSON.stringify({ name, phone_number: phoneNumber, email, address })
        });

        const data = await response.json();
        if (!data.success) throw new Error(data.message || 'Failed to update customer.');
        showModal('successModal', 'Customer updated successfully!');
        closeModal('updateModal');
        fetchCustomers();
    } catch (error) {
        console.error('Error:', error);
        showModal('errorModal', error.message, false);
    }
});

// Load customers on page load
document.addEventListener('DOMContentLoaded', fetchCustomers);