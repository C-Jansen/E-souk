<div class="p-0">
    <div class="bg-light py-3">
        <div class="profile-sidebar">
            <div class="text-center mb-3">
                <h6><?php echo htmlspecialchars($user['name']); ?></h6>
                <p class="text-muted small"><?php echo htmlspecialchars($user['role']); ?></p>
            </div>
            <div class="list-group list-group-flush">
                <?php
                // Get current page filename
                $current_page = basename($_SERVER['PHP_SELF']);
                
                // Define sidebar items with their URLs and icons
                $menu_items = [
                    // Profile & Account
                    'profile.php' => ['icon' => 'fas fa-user', 'title' => 'Profile Information'],
                    'edit-profile.php' => ['icon' => 'fas fa-edit', 'title' => 'Edit Profile'],                    
                    // Orders & Payments
                    'orders.php' => ['icon' => 'fas fa-shopping-cart', 'title' => 'My Orders'],
                    
                    // Notifications & Support
                    'support.php' => ['icon' => 'fas fa-question-circle', 'title' => 'Help & Support'],
                    
                    // Always place logout at the bottom
                    'logout.php' => ['icon' => 'fas fa-sign-out-alt', 'title' => 'Logout', 'class' => 'text-danger'],
                ];
                
                // Generate menu items
                foreach ($menu_items as $page => $item) {
                    $url = ROOT_URL . 'public/user/' . $page;
                    $is_active = ($current_page == $page) ? 'active' : '';
                    $extra_class = isset($item['class']) ? $item['class'] : '';
                    echo '<a href="' . $url . '" class="list-group-item list-group-item-action ' . $is_active . ' ' . $extra_class . '">';
                    echo '<i class="' . $item['icon'] . ' me-2"></i> ' . $item['title'];
                    echo '</a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>