<?php

session_start();

// Check admin login
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("location: login.php");
    exit;
}
include('../connection.php');
$db = Database::getInstance(); // This returns a PDO object

// Delete category
if (isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $query = "DELETE FROM category WHERE id_category = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Category deleted successfully";
    } else {
        $_SESSION['error'] = "Error deleting category";
    }
    header('Location: categories.php');
    exit();
}

// Add/Edit category
if (isset($_POST['submit'])) {
    $category_name = $_POST['category_name'];
    
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing category
        $edit_id = $_POST['edit_id'];
        $query = "UPDATE category SET name = :name WHERE id_category = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':name', $category_name, PDO::PARAM_STR);
        $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT);
        $success_msg = "Category updated successfully";
    } else {
        // Add new category
        $query = "INSERT INTO category (name) VALUES (:name)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':name', $category_name, PDO::PARAM_STR);
        $success_msg = "Category added successfully";
    }
    
    if ($stmt->execute()) {
        $_SESSION['success'] = $success_msg;
    } else {
        $_SESSION['error'] = "Error: " . implode(", ", $stmt->errorInfo());
    }
    header('Location: categories.php');
    exit();
}

// Get category data for editing
$edit_category = null;
if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $query = "SELECT * FROM category WHERE id_category = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT);
    $stmt->execute();
    $edit_category = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch all categories
$query = "SELECT * FROM category ORDER BY name";
$stmt = $db->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <?php include('includes/header.php'); ?>
    
    <div class="container-fluid">
        <div class="row">
            
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manage Categories</h1>
                </div>
                
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?php 
                            echo $_SESSION['success']; 
                            unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                            echo $_SESSION['error']; 
                            unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-5 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <?php echo $edit_category ? 'Edit Category' : 'Add New Category'; ?>
                            </div>
                            <div class="card-body">
                                <form method="post" action="">
                                    <?php if ($edit_category): ?>
                                        <input type="hidden" name="edit_id" value="<?php echo $edit_category['id_category']; ?>">
                                    <?php endif; ?>
                                    
                                    <div class="mb-3">
                                        <label for="category_name" class="form-label">Category Name</label>
                                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $edit_category ? $edit_category['name'] : ''; ?>" required>
                                    </div>
                                    
                                    <button type="submit" name="submit" class="btn btn-primary"><?php echo $edit_category ? 'Update Category' : 'Add Category'; ?></button>
                                    
                                    <?php if ($edit_category): ?>
                                        <a href="categories.php" class="btn btn-secondary">Cancel</a>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                Categories List
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if (count($categories) > 0):
                                                $counter = 1;
                                                foreach ($categories as $row): 
                                            ?>
                                                <tr>
                                                    <td><?php echo $counter++; ?></td>
                                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                    <td>
                                                        <a href="categories.php?edit_id=<?php echo $row['id_category']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                                        <a href="categories.php?delete_id=<?php echo $row['id_category']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php 
                                                endforeach; 
                                            else: 
                                            ?>
                                                <tr>
                                                    <td colspan="3" class="text-center">No categories found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
