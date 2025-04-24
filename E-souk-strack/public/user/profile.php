<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/init.php';
require_once ROOT_PATH . '/core/connection.php';
$db = Database::getInstance();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: " . ROOT_URL . "public/user/login.php");
    exit();
}

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM user WHERE id_user = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// If no user found, redirect to login
if (!$user) {
    header("Location: " . ROOT_URL . "public/user/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- Head section remains the same -->
<head>
<meta charset="UTF-8" />
   <?php include ROOT_PATH . '/public/templates/header.php'; ?>
    
</head>
<body>
    <?php include ROOT_PATH . '/public/templates/navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar remains the same -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="bg-light border-end vh-100 py-3">
                    <div class="profile-sidebar">
                        <div class="text-center mb-3">
                            <img src="https://placehold.co/150x150" alt="Profile Picture" class="avatar-small mb-2">
                            <h6><?php echo htmlspecialchars($user['name']); ?></h6>
                            <p class="text-muted small"><?php echo htmlspecialchars($user['role']); ?></p>
                        </div>
                        <div class="list-group list-group-flush">
                          
                            <a href="<?php echo ROOT_URL; ?>public/user/profile.php" class="list-group-item list-group-item-action active">
                                <i class="fas fa-user me-2"></i> Profile Information
                            </a>
                            <a href="<?php echo ROOT_URL; ?>public/user/orders.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-shopping-cart me-2"></i> My Orders
                            </a>
                            <a href="<?php echo ROOT_URL; ?>public/user/wishlist.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-heart me-2"></i> My Wishlist
                            </a>
                            <a href="<?php echo ROOT_URL; ?>public/user/reviews.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-star me-2"></i> My Reviews
                            </a>
                            <a href="<?php echo ROOT_URL; ?>public/user/logout.php" class="list-group-item list-group-item-action text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="profile-header">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <!-- Default avatar since it's not in your schema -->
                            <img src="https://placehold.co/150x150" alt="Profile Picture" class="avatar mb-3">
                        </div>
                        <div class="col-md-9">
                            <h2><?php echo htmlspecialchars($user['name']); ?></h2>
                            <p class="text-muted">Member since <?php echo date('F Y', strtotime($user['created_at'])); ?></p>
                            <div class="mt-3">
                                <a href="#" class="btn btn-primary">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Full Name:</div>
                                    <div class="col-md-9"><?php echo htmlspecialchars($user['name']); ?></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Email:</div>
                                    <div class="col-md-9"><?php echo htmlspecialchars($user['email']); ?></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Phone:</div>
                                    <div class="col-md-9"><?php echo htmlspecialchars($user['phone']); ?></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Address:</div>
                                    <div class="col-md-9"><?php echo htmlspecialchars($user['address']); ?></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Role:</div>
                                    <div class="col-md-9"><?php echo htmlspecialchars($user['role']); ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Account Security Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Account Security</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Password:</div>
                                    <div class="col-md-9">********</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-bold">Last Login:</div>
                                    <div class="col-md-9"><?php echo date('F j, Y, g:i a'); ?></div>
                                </div>
                                <div class="mt-3">
                                    <a href="change-password.php" class="btn btn-outline-primary">Change Password</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Statistics -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Account Statistics</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-4 mb-3">
                                        <h3>0</h3>
                                        <p class="text-muted">Total Orders</p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <h3>0</h3>
                                        <p class="text-muted">Wishlist Items</p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <h3>0</h3>
                                        <p class="text-muted">Reviews</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <?php include ROOT_PATH . '/public/templates/footer.php'; ?>
   
</body>
</html>
