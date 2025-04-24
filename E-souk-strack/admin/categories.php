<?php

session_start();

// Check admin login
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("location: login.php");
    exit;
}
require_once '../config/init.php';
$db = Database::getInstance(); // This returns a PDO object

// Define upload directory
$upload_dir = '../uploads/categories/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Delete category
if (isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Get the image filename before deleting
    $query = "SELECT image FROM category WHERE id_category = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Delete the record
    $query = "DELETE FROM category WHERE id_category = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        // Delete the image file if it exists
        if (!empty($category['image'])) {
            $image_path = $upload_dir . $category['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
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
    $category_description = $_POST['category_description'] ?? '';
    $image_name = null;
    
    // Handle image upload
    if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['category_image']['name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed)) {
            // Generate unique filename
            $new_filename = uniqid() . '.' . $file_ext;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['category_image']['tmp_name'], $upload_path)) {
                $image_name = $new_filename;
            } else {
                $_SESSION['error'] = "Failed to upload image";
                header('Location: categories.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid file type. Only JPG, JPEG, PNG and GIF files are allowed.";
            header('Location: categories.php');
            exit();
        }
    }
    
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update existing category
        $edit_id = $_POST['edit_id'];
        
        // Check if we need to include image in the update
        if ($image_name) {
            // Get the old image to delete it
            $query = "SELECT image FROM category WHERE id_category = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT);
            $stmt->execute();
            $old_image = $stmt->fetch(PDO::FETCH_ASSOC)['image'];
            
            $query = "UPDATE category SET name = :name, discription = :description, image = :image WHERE id_category = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':name', $category_name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $category_description, PDO::PARAM_STR);
            $stmt->bindParam(':image', $image_name, PDO::PARAM_STR);
            $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT);
            
            // Delete the old image if it exists
            if (!empty($old_image)) {
                $old_path = $upload_dir . $old_image;
                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            }
        } else {
            $query = "UPDATE category SET name = :name, discription = :description WHERE id_category = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':name', $category_name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $category_description, PDO::PARAM_STR);
            $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT);
        }
        $success_msg = "Category updated successfully";
    } else {
        // Add new category
        $query = "INSERT INTO category (name, discription, image) VALUES (:name, :description, :image)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':name', $category_name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $category_description, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image_name, PDO::PARAM_STR);
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
                                <form method="post" action="" enctype="multipart/form-data">
                                    <?php if ($edit_category): ?>
                                        <input type="hidden" name="edit_id" value="<?php echo $edit_category['id_category']; ?>">
                                    <?php endif; ?>
                                    
                                    <div class="mb-3">
                                        <label for="category_name" class="form-label">Category Name</label>
                                        <input type="text" class="form-control" id="category_name" name="category_name" 
                                            value="<?php echo $edit_category ? htmlspecialchars($edit_category['name']) : ''; ?>" required>
                                    </div>
                                    
                                    <!-- Add description field -->
                                    <div class="mb-3">
                                        <label for="category_description" class="form-label">Description</label>
                                        <textarea class="form-control" id="category_description" name="category_description" 
                                            rows="3"><?php echo $edit_category && isset($edit_category['discription']) ? htmlspecialchars($edit_category['discription']) : ''; ?></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="category_image" class="form-label">Category Image</label>
                                        <input type="file" class="form-control" id="category_image" name="category_image">
                                        <small class="form-text text-muted">Allowed formats: JPG, JPEG, PNG, GIF</small>
                                        <?php if ($edit_category && !empty($edit_category['image'])): ?>
                                            <div class="mt-2">
                                                <p>Current Image:</p>
                                                <img src="<?php echo $upload_dir . $edit_category['image']; ?>" alt="Category Image" class="img-thumbnail" style="max-width: 150px;">
                                            </div>
                                        <?php endif; ?>
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
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Description</th>
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
                                                    <td>
                                                        <?php if (!empty($row['image'])): ?>
                                                            <img src="<?php echo $upload_dir . $row['image']; ?>" alt="Category" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                                        <?php else: ?>
                                                            <span class="text-muted">No image</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                    <td><?php 
                                                    $content = isset($row['discription']) ? $row['discription'] : '';
                                                    // Display the content with truncation if needed
                                                    echo htmlspecialchars(substr($content, 0, 50)) . (strlen($content) > 50 ? '...' : '');
                                                ?></td>
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
                                                    <td colspan="5" class="text-center">No categories found</td>
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
