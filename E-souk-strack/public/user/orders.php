<?php
require_once __DIR__ . '/../../config/init.php';

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: " . ROOT_URL . "public/user/login.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user information for the sidebar
try {
    $userQuery = "SELECT * FROM user WHERE id_user = ?";  // Changed "users" to "user" and "user_id" to "id_user"
    $userStmt = $db->prepare($userQuery);
    $userStmt->execute([$user_id]);
    $user = $userStmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error fetching user: " . $e->getMessage();
    exit();
}

// Fetch orders for the current user using PDO instead of mysqli
try {
    $query = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
    // If your orders table uses id_user instead of user_id, change the query to:
    // $query = "SELECT * FROM orders WHERE id_user = ? ORDER BY order_date DESC";
    $stmt = $db->prepare($query);
    $stmt->execute([$user_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ROOT_PATH . '/public/templates/header.php'; ?>
    
    <style>
        /* Order status styling */
        .status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: capitalize;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-processing {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status-shipped {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-delivered {
            background-color: #c3e6cb;
            color: #155724;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .orders-list {
            margin: 30px 0;
        }
        
        .empty-orders {
            text-align: center;
            padding: 40px 0;
        }
        
        .empty-orders p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include ROOT_PATH . '/public/templates/navbar.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="bg-light border-end vh-100 py-3">
                    <div class="profile-sidebar">
                        <div class="text-center mb-3">
                            <img src="https://placehold.co/150x150" alt="Profile Picture" class="avatar-small mb-2">
                            <h6><?php echo htmlspecialchars($user['name']); ?></h6>
                            <p class="text-muted small"><?php echo htmlspecialchars($user['role']); ?></p>
                        </div>
                        <div class="list-group list-group-flush">
                          
                            <a href="<?php echo ROOT_URL; ?>public/user/profile.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-user me-2"></i> Profile Information
                            </a>
                            <a href="<?php echo ROOT_URL; ?>public/user/orders.php" class="list-group-item list-group-item-action active">
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
            
            <!-- Main content -->
            <div class="col-md-9 col-lg-10">
                <div class="container py-4">
                    <h1>My Orders</h1>
                    
                    <?php if (!empty($orders)): ?>
                        <div class="orders-list">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>#<?php echo $order['id_order']; ?></td>
                                            <td><?php echo date('F j, Y', strtotime($order['order_date'])); ?></td>
                                            <td>
                                                <span class="status status-<?php echo strtolower($order['status']); ?>">
                                                    <?php echo $order['status']; ?>
                                                </span>
                                            </td>
                                            <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                                            <td>
                                                <a href="<?php echo ROOT_URL; ?>/user/order_details.php?id=<?php echo $order['id_order']; ?>" class="btn btn-small">View Details</a>
                                                <?php if ($order['status'] == 'Pending'): ?>
                                                    <a href="<?php echo ROOT_URL; ?>/user/cancel_order.php?id=<?php echo $order['id_order']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-orders">
                            <p>You haven't placed any orders yet.</p>
                            <a href="<?php echo ROOT_URL; ?>public/pages/product.php" class="btn">Start Shopping</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php include ROOT_PATH . '/public/templates/footer.php'; ?>
</body>
</html>