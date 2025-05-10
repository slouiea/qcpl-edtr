<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include '../db.php';

// Create connection
$conn = connectDB();

// Check if the user is an admin
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();

if ($role !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

// Fetch branches and employees for filters
$branches_result = $conn->query("SELECT branch_name FROM branches");
$branches = [];
while ($branch_row = $branches_result->fetch_assoc()) {
    $branches[] = $branch_row['branch_name'];
}

$employees_result = $conn->query("SELECT employee_id, CONCAT(employee_firstname, ' ', employee_lastname) AS employee_name, branch 
                                  FROM employees");
$employees = [];
while ($employee_row = $employees_result->fetch_assoc()) {
    $employees[] = $employee_row;
}

// Handle form submission for generating DTR
$employees_filtered = [];
$selected_month = $_POST['month'] ?? date('n');
$selected_year = $_POST['year'] ?? date('Y');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generate_dtr'])) {
    $branch = $_POST['branch'];
    $search_employee = $_POST['search_employee'] ?? '';

    $query = "SELECT employee_id, 
                     CONCAT(employee_firstname, ' ', employee_lastname) AS employee_name, 
                     branch 
              FROM employees 
              WHERE 1=1";
    $params = [];
    $types = "";

    if ($branch) {
        $query .= " AND branch = ?";
        $params[] = $branch;
        $types .= "s";
    }

    if ($search_employee) {
        $query .= " AND CONCAT(employee_firstname, ' ', employee_lastname) LIKE ?";
        $params[] = "%" . $search_employee . "%";
        $types .= "s";
    }

    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $employees_filtered[] = $row;
    }

    $stmt->close();
} else {
    // Default: Fetch all employees
    $result = $conn->query("SELECT employee_id, 
                                   CONCAT(employee_firstname, ' ', employee_lastname) AS employee_name, 
                                   branch 
                            FROM employees");
    while ($row = $result->fetch_assoc()) {
        $employees_filtered[] = $row;
    }
}

$title = "Generate Employee DTR";
$content = "generate_dtr_content.php";
include('template.php');
?>