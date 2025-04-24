<?php
// Only start session if one isn't already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/init.php';
require_once ROOT_PATH . '/core/connection.php';
$db = Database::getInstance();
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="<?php echo ROOT_URL; ?>public/pages/index.php">
            <img src="<?php echo ROOT_URL; ?>public/assets/images/logo.png" alt="E-Souk Logo" height="40">
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
          <ul class="navbar-nav me-auto">
            <!-- Categories Dropdown -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" >Produits</a>
              <ul class="dropdown-menu">
                <!-- Tapis & Kilims -->
                <li class="dropdown-submenu">
                  <a class="dropdown-item dropdown-toggle" href="#">Tapis & Kilims</a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Tapis</a></li>
                    <li><a class="dropdown-item" href="#">Kilims</a></li>
                  </ul>
                </li>

                <!-- Accessoires -->
                <li class="dropdown-submenu">
                  <a class="dropdown-item dropdown-toggle" href="#">Accessoires</a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Écharpes</a></li>
                    <li><a class="dropdown-item" href="#">Sacs</a></li>
                    <li><a class="dropdown-item" href="#">Bijoux</a></li>
                    <li><a class="dropdown-item" href="#">Babouches</a></li>
                  </ul>
                </li>

                <!-- Poterie -->
                <li class="dropdown-submenu">
                  <a class="dropdown-item dropdown-toggle" href="#">Poterie</a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Decoration</a></li>
                    <li><a class="dropdown-item" href="#">Veilleuse</a></li>
                    <li><a class="dropdown-item" href="#">Oreillers</a></li>
                    <li><a class="dropdown-item" href="#">Meubles</a></li>
                    
                  </ul>
                </li>

                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>public/pages/product.php">Tous les produits</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="<?php echo ROOT_URL; ?>public/pages/about.php">À PROPOS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo ROOT_URL; ?>public/pages/vision.php">COMING SOON!</a>
            </li>
          </ul>

            <!-- Search Bar -->
            <form class="d-flex mx-lg-3" action="<?php echo ROOT_URL; ?>public/pages/search.php" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="q" placeholder="Rechercher...">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- User Section -->
            <div class="d-flex">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link me-3 dropdown-toggle" data-bs-toggle="dropdown" id="userDropdown">
                        <i class="fas fa-user"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <!-- User is logged in -->
                            <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>public/user/profile.php">Mon Compte</a></li>
                            <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>core/logout.php">Déconnexion</a></li>
                        <?php else: ?>
                            <!-- User is not logged in -->
                            <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>public/user/login.php">Connexion</a></li>
                            <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>public/user/register.php">Inscription</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <a href="<?php echo ROOT_URL; ?>public/pages/contact.php" class="nav-link me-3">
                    <i class="fas fa-envelope"></i>
                </a>

                <!-- Wishlist -->
                <a href="<?php echo ROOT_URL; ?>public/pages/wishlist.php" class="nav-link me-3 position-relative">
                    <i class="fas fa-heart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php
                        $wishlist_count = 0;
                        if(isset($_SESSION['user_id'])) {
                            $stmt = $db->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id = ?");
                            $stmt->execute([$_SESSION['user_id']]);
                            $wishlist_count = $stmt->fetchColumn();
                        }
                        echo $wishlist_count;
                        ?>
                    </span>
                </a>

                <!-- Cart -->
                <a href="<?php echo ROOT_URL; ?>public/pages/cart.php" class="nav-link position-relative">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>
                    </span>
                </a>
            </div>
        </div>
    </div>
</nav>