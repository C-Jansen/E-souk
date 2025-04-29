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
        /* User dashboard layout */
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
    
    <div class="container-fluid p-0">
        <div class="user-dashboard">
            <!-- Sidebar Container -->
            <div class="sidebar-container">
                <?php include ROOT_PATH . '/public/user/includes/sidebar.php'; ?>
            </div>
            
            <!-- Content Container -->
            <div class="content-container">
                <div class="container">
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