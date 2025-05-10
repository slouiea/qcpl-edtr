<!DOCTYPE html>
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

// Handle form submission for creating a new branch
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_branch'])) {
    $branch_name = $_POST['branch_name'];
    $branch_address = $_POST['branch_address'];

    $stmt = $conn->prepare("INSERT INTO branches (branch_name, branch_address) VALUES (?, ?)");
    $stmt->bind_param("ss", $branch_name, $branch_address);
    $stmt->execute();
    $stmt->close();
}

// Handle form submission for editing a branch
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_branch'])) {
    $id = $_POST['id'];
    $branch_name = $_POST['branch_name'];
    $branch_address = $_POST['branch_address'];

    $stmt = $conn->prepare("UPDATE branches SET branch_name = ?, branch_address = ? WHERE id = ?");
    $stmt->bind_param("ssi", $branch_name, $branch_address, $id);
    $stmt->execute();
    $stmt->close();
}

// Handle form submission for deleting a branch
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_branch'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM branches WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Handle form submission for filtering and sorting branches
$search_keyword = isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '';
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$items_per_page = 10;
$offset = ($page - 1) * $items_per_page;

// Fetch branches from the database with filters and sorting
$query = "SELECT * FROM branches WHERE branch_name LIKE '%$search_keyword%' OR branch_address LIKE '%$search_keyword%' LIMIT $items_per_page OFFSET $offset";
$result = $conn->query($query);

// Get total number of branches for pagination
$total_result = $conn->query("SELECT COUNT(*) AS total FROM branches WHERE branch_name LIKE '%$search_keyword%' OR branch_address LIKE '%$search_keyword%'");
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $items_per_page);

$title = "Branches";
$content = "branches_content.php";
include('template.php');
?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js"></script>
<script>
    $('#editBranchModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var branch_name = button.data('branch_name');
        var branch_address = button.data('branch_address');

        var modal = $(this);
        modal.find('#edit_id').val(id);
        modal.find('#edit_branch_name').val(branch_name);
        modal.find('#edit_branch_address').val(branch_address);
    });

    $('#deleteBranchModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        var modal = $(this);
        modal.find('#delete_id').val(id);
    });
</script>
</body>
</html>