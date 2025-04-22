<?php
// Don't include the API file here, as it would output JSON before the HTML
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .employee-list { margin-top: 20px; }
        .employee { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; }
        .modal-content { background-color: white; padding: 20px; border-radius: 5px; width: 300px; }
        .modal button { margin-top: 10px; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Employee Management System</h1>

    <!-- Add Employee Form -->
    <h2>Add Employee</h2>
    <form id="addEmployeeForm">
        <input type="text" id="name" placeholder="Name" required><br><br>
        <input type="text" id="occupation" placeholder="Occupation" required><br><br>
        <input type="text" id="phoneNumber" placeholder="Phone (xxx-xxx-xxxx)" required><br><br>
        <input type="date" id="hireDate" required><br><br>
        <button type="submit">Add Employee</button>
    </form>
    <div id="addResult"></div>

    <!-- Employee List -->
    <h2>Employees</h2>
    <div id="employeeList" class="employee-list"></div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <h3>Success</h3>
            <p id="successModalMessage"></p>
            <button onclick="closeModal('successModal')">Close</button>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <h3>Error</h3>
            <p id="errorModalMessage"></p>
            <button onclick="closeModal('errorModal')">Close</button>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <h3>Are you sure?</h3>
            <p id="confirmationMessage"></p>
            <button id="confirmActionBtn">Yes</button>
            <button onclick="closeModal('confirmationModal')">No</button>
        </div>
    </div>

    <!-- Update Modal -->
<div id="updateModal" class="modal">
    <div class="modal-content">
        <h3>Update Employee</h3>
        <form id="updateEmployeeForm">
            <input type="hidden" id="updateId">
            <label>Name: <input type="text" id="updateName" required></label><br>
            <label>Occupation: <input type="text" id="updateOccupation" required></label><br>
            <label>Phone: <input type="text" id="updatePhoneNumber" required></label><br>
            <button type="submit">Update</button>
            <button type="button" onclick="closeModal('updateModal')">Cancel</button>
        </form>
    </div>
</div>

    <!-- Include the external JavaScript file -->
    <script src="script.js"></script>
</body>
</html>