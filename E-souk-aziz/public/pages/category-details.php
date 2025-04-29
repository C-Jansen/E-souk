<?php 
session_start();

// Database connection
require_once __DIR__ . '/../../config/init.php';

$db = Database::getInstance();

// Get category ID from URL
$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch category information with all fields
$categoryQuery = $db->prepare("SELECT * FROM category WHERE id_category = ?");
$categoryQuery->execute([$category_id]);
$category = $categoryQuery->fetch(PDO::FETCH_ASSOC);

// Check if category exists
if (!$category) {
    // Category not found - handle gracefully
    $page_title = "Catégorie non trouvée - E-Souk Tounsi";
    $page_description = "Nous n'avons pas pu trouver la catégorie que vous recherchez.";
    $category = [
        'name' => 'Catégorie non trouvée',
        'id_category' => 0,
        'discription' => 'Cette catégorie n\'existe pas.', // Changed from 'description' to 'discription'
        'image' => 'default-category.jpg'
    ];
} else {
    // Set page title and description
    $page_title = htmlspecialchars($category['name']) . " - E-Souk Tounsi";
    $page_description = "Découvrez notre collection " . htmlspecialchars($category['name']) . " - E-Souk Tounsi";
}

// Fetch products for this category with sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'position';

$order_by = 'created_at DESC'; // Default
if ($sort == 'price-low') {
    $order_by = 'price ASC';
} elseif ($sort == 'price-high') {
    $order_by = 'price DESC';
} elseif ($sort == 'newest') {
    $order_by = 'created_at DESC';
}

// Only query for products if category exists
$products = [];
$total_products = 0;
$featuredImages = ['placeholder.jpg'];

if ($category['id_category'] > 0) {
    $productsQuery = $db->prepare("SELECT * FROM product WHERE category_id = ? ORDER BY " . $order_by);
    $productsQuery->execute([$category_id]);
    $products = $productsQuery->fetchAll(PDO::FETCH_ASSOC);
    
    // Get total count of products
    $total_products = count($products);
    
    // Get category-specific featured images
    $featuredImagesQuery = $db->prepare("SELECT image FROM product WHERE category_id = ? LIMIT 5");
    $featuredImagesQuery->execute([$category_id]);
    $featuredImages = $featuredImagesQuery->fetchAll(PDO::FETCH_COLUMN);
    
    // If no images available, use a placeholder
    if (empty($featuredImages)) {
        $featuredImages = ['placeholder.jpg'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/category-detail.css">
    <?php include '../templates/header.php'; ?>
    <style>
        .category-hero-section {
            background-image: url('../uploads/categories/<?= htmlspecialchars($category['image'] ?: 'default-category.jpg') ?>');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body>
    <?php include '../templates/navbar.php'; ?>

    <!-- Enhanced Hero Section with Category Banner -->
    <section class="category-hero-section">
        <div class="hero-bg-overlay"></div>
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <div class="col-lg-8 text-white">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($category['name']) ?></li>
                        </ol>
                    </nav>
                    <h1 class="hero-title"><?= htmlspecialchars($category['name']) ?></h1>
                    <p class="hero-subtitle">
                        <?php if (isset($category['discription']) && $category['discription'] !== null): ?>
                            <?= htmlspecialchars(substr($category['discription'], 0, 150)) ?>
                            <?= (strlen($category['discription']) > 150) ? '...' : '' ?>
                        <?php else: ?>
                            Découvrez notre sélection de produits <?= htmlspecialchars($category['name']) ?>
                        <?php endif; ?>
                    </p>
                    <div class="hero-buttons d-flex mt-4">
                        <a href="#product-grid" class="btn btn-primary me-3">Découvrir les produits</a>
                        <a href="index.php" class="btn btn-outline-light">Retour à l'accueil</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Overview Section -->
    <section class="category-content-section">
        <div class="container">
            <div class="category-overview shadow-sm">
                <div class="row">
                    <div class="col-lg-7">
                        <h2 class="mb-4"><?= htmlspecialchars($category['name']) ?></h2>
                        <div class="category-description">
                            <?php if (isset($category['discription']) && $category['discription'] !== null): ?>
                                <?= nl2br(htmlspecialchars($category['discription'])) ?>
                            <?php else: ?>
                                <p>Découvrez notre gamme exclusive de produits <?= htmlspecialchars($category['name']) ?>.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="category-featured">
                            <?php if (!empty($featuredImages) && $featuredImages[0] != 'placeholder.jpg'): ?>
                            <div class="featured-images-grid">
                                <?php foreach(array_slice($featuredImages, 0, 4) as $img): ?>
                                <img src="../uploads/products/<?= htmlspecialchars($img) ?>" alt="Featured Product" class="img-fluid">
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="product-grid" class="product-grid-section">
        <div class="container">
            <div class="row">
                <!-- Sidebar for Shop By Filters -->
                <div class="col-lg-3 shop-by-section">
                    <h3 class="shop-by-title">Shop By</h3>
                    <!-- Best Seller Filter -->
                    <div class="mb-4">
                        <h4 class="h6 mb-3">Product Type</h4>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="type-1">
                            <label class="form-check-label" for="type-1">
                                Best Sellers
                            </label>
                        </div>
                        
                    </div>
                </div>

                <!-- Main Product Grid -->
                <div class="col-lg-9">
                    <!-- Filter and Sort -->
                    <div class="product-grid-header">
                        <div>
                            <h2 class="product-grid-title">All Products</h2>
                            <p class="items-count mb-0">Showing <?= min($total_products, 24) ?> of <?= $total_products ?> products</p>
                        </div>
                        <div class="sort-container">
                            <label for="sort-select" class="me-2">Sort By:</label>
                            <select id="sort-select" class="form-select form-select-sm">
                                <option value="position" <?= $sort == 'position' ? 'selected' : '' ?>>Position</option>
                                <option value="price-low" <?= $sort == 'price-low' ? 'selected' : '' ?>>Prix: croissant</option>
                                <option value="price-high" <?= $sort == 'price-high' ? 'selected' : '' ?>>Prix: décroissant</option>
                                <option value="newest" <?= $sort == 'newest' ? 'selected' : '' ?>>Plus récent</option>
                            </select>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="row">
                        <?php if (count($products) > 0): ?>
                            <?php foreach ($products as $product): ?>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="product-card">
                                        <div class="wishlist-icon" data-product-id="<?= $product['id_product'] ?>" onclick="toggleWishlist(<?= $product['id_product'] ?>, this)">
                                            <?php
                                            // Define $inWishlist variable
                                            $inWishlist = isset($_SESSION['wishlist']) && in_array($product['id_product'], $_SESSION['wishlist']);
                                            ?>
                                            <i class="<?= $inWishlist ? 'fas' : 'far' ?> fa-heart"></i>
                                            
                                        </div>
                                        <div class="product-image">
                                            <a href="product.php?id=<?= $product['id_product'] ?>">
                                                <img src="../../root_uploads/products/<?= htmlspecialchars($product['image']) ?>" 
                                                     alt="<?= htmlspecialchars($product['title']) ?>">
                                            </a>
                                            <?php if (isset($product['is_best_seller']) && $product['is_best_seller']): ?>
                                                <span class="best-seller-badge">Best Seller</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="product-details">
                                            <div class="d-flex justify-content-between">
                                                <h5><a href="product.php?id=<?= $product['id_product'] ?>"><?= htmlspecialchars($product['title']) ?></a></h5>
                                                <span class="price"><?= number_format($product['price'], 2) ?> DT</span>
                                            </div>
                                            <p class="product-description"><?= substr(htmlspecialchars($product['description']), 0, 80) ?>...</p>
                                            <div class="product-btn-container">
                                                <button class="add-to-cart-btn" data-product-id="<?= $product['id_product'] ?>">
                                                    <i class="fas fa-shopping-cart"></i> Ajouter au panier
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="alert alert-info">
                                    Aucun produit trouvé dans cette catégorie.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination if needed -->
                    <?php if ($total_products > 24): ?>
                    <nav aria-label="Product pagination" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Précédent</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Suivant</a>
                            </li>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php include '../templates/Topbtn.php'; ?>
    <?php include '../templates/newsletter.php'; ?>                    
    <?php include '../templates/footer.php'; ?>

    
    <script>
        // Make ROOT_URL available to JavaScript if not already defined in header
        const ROOT_URL = '<?php echo ROOT_URL; ?>';
        
        // Override the sort select behavior for this specific page
        document.addEventListener('DOMContentLoaded', function() {
            const sortSelect = document.getElementById('sort-select');
            if (sortSelect) {
                // Remove the default event listener that might be added by esouk.js
                const newSortSelect = sortSelect.cloneNode(true);
                sortSelect.parentNode.replaceChild(newSortSelect, sortSelect);
                
                // Add the category-specific sort behavior
                newSortSelect.addEventListener('change', function() {
                    const sortValue = this.value;
                    window.location.href = `category-details.php?id=<?= $category_id ?>&sort=${sortValue}`;
                });
            }
        });
    </script>
      
    <script src="<?php echo ASSETS_URL; ?>js/cart.js"></script>
    <script src="<?php echo ASSETS_URL; ?>js/wishlist.js"></script>
</body>
</html>
