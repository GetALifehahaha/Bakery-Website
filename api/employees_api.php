<?php
require_once __DIR__ . '/../class/employees.php';

// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // For development; restrict in production
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Initialize Employees class
$employees = new Employees();

// Parse request path
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_path = '/BakeryKey/api/employees_api.php'; // Adjust this to match your actual base path

// Extract ID from URI if present
$id = null;
if (strpos($request_uri, $base_path) === 0) {
    $path_info = substr($request_uri, strlen($base_path));
    if (preg_match('#^/(\d+)$#', $path_info, $matches)) {
        $id = (int)$matches[1];
    }
}

// Alternative approach for ID extraction from query parameters
if ($id === null && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
}

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'GET':
        if ($id) {
            // Get single employee
            $employee = $employees->getEmployee($id);
            if ($employee) {
                echo json_encode(['success' => true, 'data' => [$id => $employee]]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Employee not found']);
            }
        } else {
            // Get all employees
            $allEmployees = $employees->getAllEmployees();
            if (empty($allEmployees)) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'No employees found']);
                break;
            }
            $indexedEmployees = [];
            foreach ($allEmployees as $emp) {
                $indexedEmployees[$emp['employee_ID']] = $emp;
            }
            echo json_encode([
                'success' => true,
                'data' => $indexedEmployees,
                'total' => count($indexedEmployees)
            ]);
        }
        break;

    case 'POST':
        // Add new employee
        $data = json_decode(file_get_contents('php://input'), true);
        $name = isset($data['name']) ? $data['name'] : '';
        $occupation = isset($data['occupation']) ? $data['occupation'] : '';
        $phoneNumber = isset($data['phone_number']) ? $data['phone_number'] : '';
        $hireDate = isset($data['hire_date']) ? $data['hire_date'] : '';

        if (empty($name) || empty($occupation) || empty($phoneNumber) || empty($hireDate)) {
            http_response_code(400);  // Bad Request
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            break;
        }

        $newId = $employees->addEmployee($name, $occupation, $phoneNumber, $hireDate);
        if ($newId) {
            http_response_code(201);  // Created
            echo json_encode(['success' => true, 'id' => $newId, 'message' => 'Employee added']);
        } else {
            http_response_code(500);  // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Failed to add employee']);
        }
        break;

        case 'PUT':
            if (!$id) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Employee ID required']);
                break;
            }
        
            $data = json_decode(file_get_contents('php://input'), true);
            $name = $data['name'] ?? '';
            $occupation = $data['occupation'] ?? '';
            $phoneNumber = $data['phone_number'] ?? '';
            $hireDate = $data['hire_date'] ?? null; // Optional
        
            if ($employees->updateEmployee($id, $name, $occupation, $phoneNumber, $hireDate)) {
                echo json_encode(['success' => true, 'message' => 'Employee updated']);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Failed to update employee']);
            }
            break;
        

    case 'DELETE':
        if ($id) {
            $deleted = $employees->deleteEmployee($id);
            if ($deleted) {
                echo json_encode(['success' => true, 'message' => 'Employee deleted']);
            } else {
                http_response_code(400);  // Bad Request
                echo json_encode(['success' => false, 'message' => 'Failed to delete employee']);
            }
        } else {
            http_response_code(400);  // Bad Request
            echo json_encode(['success' => false, 'message' => 'Employee ID required']);
        }
        break;
}
?>
