<?php
// database/db_test.php

// Adjust paths to include Database.php and Employees.php
require_once __DIR__ . '/Database.php';          
require_once __DIR__ . '/../class/employees.php';  // Updated to the correct filename

// Set headers for JSON response (optional for testing)
header('Content-Type: application/json');

// Test database connection
function testConnection() {
    $db = new Database();
    $conn = $db->getConnection();
    if ($conn) {
        return ['success' => true, 'message' => 'Database connection successful'];
    }
    return ['success' => false, 'message' => 'Database connection failed'];
}

// Test Employees class operations
function testEmployeeOperations() {
    $employees = new Employees();
    $results = [];

    // Test 1: Add an employee
    $newId = $employees->addEmployee('Test Employee', 'Tester', '123-456-7890', '2023-01-01');
    if ($newId) {
        $results['add'] = ['success' => true, 'id' => $newId, 'message' => 'Employee added'];
    } else {
        $results['add'] = ['success' => false, 'message' => 'Failed to add employee'];
    }

    // Test 2: Get all employees
    $allEmployees = $employees->getAllEmployees();
    if (!empty($allEmployees)) {
        $results['getAll'] = ['success' => true, 'count' => count($allEmployees), 'message' => 'Fetched all employees'];
    } else {
        $results['getAll'] = ['success' => false, 'message' => 'No employees found or fetch failed'];
    }

    // Test 3: Get single employee
    if ($newId) {
        $employee = $employees->getEmployee($newId);
        if ($employee) {
            $results['getOne'] = ['success' => true, 'employee' => $employee, 'message' => 'Fetched employee by ID'];
        } else {
            $results['getOne'] = ['success' => false, 'message' => 'Failed to fetch employee by ID'];
        }
    }

    // Test 4: Update employee
    if ($newId) {
        $updated = $employees->updateEmployee($newId, 'Updated Employee');
        if ($updated) {
            $results['update'] = ['success' => true, 'message' => 'Employee updated'];
        } else {
            $results['update'] = ['success' => false, 'message' => 'Failed to update employee'];
        }
    }

    // Test 5: Delete employee
    if ($newId) {
        $deleted = $employees->deleteEmployee($newId);
        if ($deleted) {
            $results['delete'] = ['success' => true, 'message' => 'Employee deleted'];
        } else {
            $results['delete'] = ['success' => false, 'message' => 'Failed to delete employee'];
        }
    }

    return $results;
}

// Run tests
$connectionTest = testConnection();
$operationTests = testEmployeeOperations();

// Output results
echo json_encode([
    'connection' => $connectionTest,
    'operations' => $operationTests
]);
?>