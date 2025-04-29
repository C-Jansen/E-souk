<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once __DIR__ . '/../../config/init.php';

$user_id = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

// Fetch current user data
try {
    $stmt = $db->prepare("SELECT * FROM user WHERE id_user = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error_message = "Error retrieving user data: " . $e->getMessage();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    
    // Basic validation
    if (empty($name) || empty($email)) {
        $error_message = "Name and email are required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } else {
        try {
            // Check if email already exists for another user
            $stmt = $db->prepare("SELECT id_user FROM user WHERE email = ? AND id_user != ?");
            $stmt->execute([$email, $user_id]);
            if ($stmt->rowCount() > 0) {
                $error_message = "Email already in use by another account.";
            } else {
                // Handle image upload if provided
                $image = $user['image']; // Keep existing image by default
                
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                    $filename = $_FILES['image']['name'];
                    $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    
                    if (in_array($file_ext, $allowed)) {
                        $new_image = 'user_' . $user_id . '_' . time() . '.' . $file_ext;
                        $upload_path = '../../uploads/users/' . $new_image;
                        
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                            $image = $new_image;
                        } else {
                            $error_message = "Failed to upload image.";
                        }
                    } else {
                        $error_message = "Invalid file format. Allowed formats: jpg, jpeg, png, gif";
                    }
                }
                
                if (empty($error_message)) {
                    // Update user data
                    $stmt = $db->prepare("UPDATE user SET name = ?, email = ?, phone = ?, address = ?, image = ? WHERE id_user = ?");
                    $stmt->execute([$name, $email, $phone, $address, $image, $user_id]);
                    
                    // Handle password change if provided
                    if (!empty($_POST['new_password'])) {
                        if (strlen($_POST['new_password']) < 6) {
                            $error_message = "Password must be at least 6 characters long.";
                        } elseif ($_POST['new_password'] !== $_POST['confirm_password']) {
                            $error_message = "New passwords do not match.";
                        } else {
                            $hashed_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                            $stmt = $db->prepare("UPDATE user SET password = ? WHERE id_user = ?");
                            $stmt->execute([$hashed_password, $user_id]);
                        }
                    }
                    
                    if (empty($error_message)) {
                        $success_message = "Profile updated successfully!";
                        // Refresh user data
                        $stmt = $db->prepare("SELECT * FROM user WHERE id_user = ?");
                        $stmt->execute([$user_id]);
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                }
            }
        } catch(PDOException $e) {
            $error_message = "Error updating profile: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/public/templates/header.php'; ?>
    <style>
        .user-dashboard {
            display: flex;
            min-height: calc(100vh - 150px);
        }
        .sidebar-container {
            width: 250px;
            flex-shrink: 0;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        .content-container {
            flex-grow: 1;
            padding: 20px;
        }
        @media (max-width: 767px) {
            .user-dashboard {
                flex-direction: column;
            }
            .sidebar-container {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #dee2e6;
            }
        }
    </style>
</head>
<body>
    <!-- Include header -->
    <?php include ROOT_PATH . '/public/templates/navbar.php'; ?>
    
    <div class="container-fluid p-0">
        <div class="user-dashboard">
            <!-- Sidebar Container -->
            <div class="sidebar-container">
                <?php include ROOT_PATH . '/public/user/includes/sidebar.php'; ?>
            </div>
            
            <!-- Content Container -->
            <div class="content-container">
                <div class="px-4 py-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h4 class="mb-0">Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($success_message)): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php echo $success_message; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($error_message)): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo $error_message; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST" action="" enctype="multipart/form-data">
                            <div class="mb-4">
                                    <label for="image" class="form-label">Profile Image</label>
                                    <div class="row align-items-center">
                                        <?php if (!empty($user['image'])): ?>
                                            <div class="col-auto mb-2">
                                                <img src="../../uploads/users/<?php echo htmlspecialchars($user['image']); ?>" alt="Profile Image" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                            </div>
                                        <?php endif; ?>
                                        <div class="col">
                                            <input type="file" class="form-control" id="image" name="image">
                                            <div class="form-text">Allowed formats: JPG, JPEG, PNG, GIF</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" id="address" name="address" rows="3"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                                
                             
                                <hr  class="my-4">
                                <h5>Change Password</h5>
                                <p class="text-muted small">Leave blank if you don't want to change your password</p>
                                
                                <div herf="#" class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password">
                                        <div class="form-text">Password must be at least 6 characters long.</div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include ROOT_PATH . '/public/templates/footer.php'; ?>
    
</body>
</html>