<?php
// Initialize the session
session_start();

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("location: login.php");
    exit;
}

// Include database connection
require_once "../connection.php";
$conn = Database::getInstance();

// Process delete operation
if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"])) {
    $id = trim($_GET["id"]);
    $sql = "DELETE FROM user WHERE id_user = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        $_SESSION["success_msg"] = "User deleted successfully";
    } else {
        $_SESSION["error_msg"] = "Something went wrong. Please try again later.";
    }
    
    header("location: users.php");
    exit;
}

try {
    // Fetch all users with PDO
    $sql = "SELECT id_user, name, email, role, address, phone, created_at FROM user ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION["error_msg"] = "Database error: " . $e->getMessage();
    $users = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- Head section remains the same -->
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <?php include "includes/header.php"; ?>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Missing sidebar here -->
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <h2>User Management</h2>
                
                <?php if (isset($_SESSION["success_msg"])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION["success_msg"] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION["success_msg"]); ?>
                <?php endif; ?>
                
                <?php if (isset($_SESSION["error_msg"])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION["error_msg"] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION["error_msg"]); ?>
                <?php endif; ?>
                
                <div class="d-flex justify-content-between mb-3">
                    <p>Manage system users</p>
                    <a href="add_user.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New User
                    </a>
                </div>
                
                <!-- Table structure updated -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Users List
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($users) > 0): ?>
                                        <?php foreach($users as $row): ?>
                                        <tr>
                                            <td><?= $row["id_user"] ?></td>
                                            <td><?= htmlspecialchars($row["name"]) ?></td>
                                            <td><?= htmlspecialchars($row["email"]) ?></td>
                                            <td>
                                                <span class="badge bg-<?= $row["role"] == "admin" ? "danger" : "info" ?>">
                                                    <?= ucfirst(htmlspecialchars($row["role"])) ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($row["address"] ?? '') ?></td>
                                            <td><?= htmlspecialchars($row["phone"] ?? '') ?></td>
                                            <td><?= $row["created_at"] ?></td>
                                            <td>
                                                <a href="edit_user.php?id=<?= $row["id_user"] ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="users.php?action=delete&id=<?= $row["id_user"] ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">No users found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable();
        });
    </script>
    
    <?php include "includes/footer.php"; ?>
    
    <!-- Scripts remain the same -->
</body>
</html>
