<?php
require_once __DIR__ . '/../class/customers.php';

// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // For development; restrict in production
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Initialize Customers class
$customers = new Customers();

// Parse request path
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_path = '/Bakery-Website/api/customers_api.php'; // Adjusted to match customer API endpoint

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
            // Get single customer
            $customer = $customers->getCustomer($id);
            if ($customer) {
                echo json_encode(['success' => true, 'data' => [$id => $customer]]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Customer not found']);
            }
        } else {
            // Get all customers
            $allCustomers = $customers->getAllCustomers();
            if (empty($allCustomers)) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'No customers found']);
                break;
            }
            $indexedCustomers = [];
            foreach ($allCustomers as $cust) {
                $indexedCustomers[$cust['customer_ID']] = $cust;
            }
            echo json_encode([
                'success' => true,
                'data' => $indexedCustomers,
                'total' => count($indexedCustomers)
            ]);
        }
        break;

    case 'POST':
        // Add new customer
        $data = json_decode(file_get_contents('php://input'), true);
        $name = isset($data['name']) ? $data['name'] : '';
        $phoneNumber = isset($data['phone_number']) ? $data['phone_number'] : '';
        $email = isset($data['email']) ? $data['email'] : '';
        $address = isset($data['address']) ? $data['address'] : '';

        if (empty($name) || empty($phoneNumber) || empty($email) || empty($address)) {
            http_response_code(400);  // Bad Request
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            break;
        }

        $newId = $customers->addCustomer($name, $phoneNumber, $email, $address);
        if ($newId) {
            http_response_code(201);  // Created
            echo json_encode(['success' => true, 'id' => $newId, 'message' => 'Customer added']);
        } else {
            http_response_code(500);  // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Failed to add customer']);
        }
        break;

    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Customer ID required']);
            break;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'] ?? '';
        $phoneNumber = $data['phone_number'] ?? '';
        $email = $data['email'] ?? '';
        $address = $data['address'] ?? '';

        if ($customers->updateCustomer($id, $name, $phoneNumber, $email, $address)) {
            echo json_encode(['success' => true, 'message' => 'Customer updated']);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Failed to update customer']);
        }
        break;

    case 'DELETE':
        if ($id) {
            $deleted = $customers->deleteCustomer($id);
            if ($deleted) {
                echo json_encode(['success' => true, 'message' => 'Customer deleted']);
            } else {
                http_response_code(400);  // Bad Request
                echo json_encode(['success' => false, 'message' => 'Failed to delete customer']);
            }
        } else {
            http_response_code(400);  // Bad Request
            echo json_encode(['success' => false, 'message' => 'Customer ID required']);
        }
        break;
}
?>