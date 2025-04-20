<?php
session_start();
$host = 'localhost';
$dbname = 'bd-esouk-2';
$username = 'aziz';
$password = 'jradz123';
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// If no valid ID, redirect to products page
if ($product_id <= 0) {
    header('Location: product.php');
    exit;
}

// Fetch product data
$stmt = $db->prepare("SELECT p.*, c.name as category_name 
                     FROM product p 
                     LEFT JOIN category c ON p.category_id = c.id_category 
                     WHERE p.id_product = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// If product not found, redirect
if (!$product) {
    header('Location: product.php');
    exit;
}

// Set page title and description
$page_title = htmlspecialchars($product['title']) . " - E-Souk Tounsi";
$page_description = htmlspecialchars(substr($product['description'], 0, 155));

// Add to cart functionality (can be expanded later)
$message = '';
if (isset($_POST['add_to_cart'])) {
    // Simple cart functionality - can be expanded based on your cart implementation
    $message = '<div class="alert alert-success">Product added to cart successfully!</div>';
    // Here you would add the actual cart adding logic
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <meta name="description" content="<?= $page_description ?>">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
    <?php include './assets/templates/navbar.php'; ?>

    <!-- Product Detail Section -->
    <section class="product-detail-section py-5">
        <div class="container">
            <?php if (!empty($message)): ?>
                <?= $message ?>
            <?php endif; ?>
            
            <div class="row">
                <!-- Product Image -->
                <div class="col-md-6 mb-4">
                    <div class="product-image-container">
                        <img src="./uploads/products/<?= htmlspecialchars($product['image']) ?>" 
                             alt="<?= htmlspecialchars($product['title']) ?>" class="img-fluid">
                    </div>
                </div>
                
                <!-- Product Details -->
                <div class="col-md-6">
                    <h1 class="product-title"><?= htmlspecialchars($product['title']) ?></h1>
                    
                    <?php if ($product['category_id']): ?>
                        <div class="mb-3">
                            <span class="badge bg-primary"><?= htmlspecialchars($product['category_name']) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="product-sku">Ref: PROD-<?= $product['id_product'] ?></div>
                    
                    <div class="stock-badge <?= $product['stock'] > 0 ? '' : 'out-of-stock' ?>">
                        <?= $product['stock'] > 0 ? 'In stock' : 'Out of stock' ?>
                    </div>
                    
                    <div class="product-price mb-4">
                        <span class="price h3"><?= number_format($product['price'], 2) ?> DT</span>
                    </div>
                    
                    <div class="product-description mb-4">
                        <?= nl2br(htmlspecialchars($product['description'])) ?>
                    </div>
                    
                    <form method="post" action="">
                        <div class="quantity-selector">
                            <label for="quantity">Quantity:</label>
                            <div class="input-group quantity-input-group">
                                <button type="button" class="btn btn-sm" id="decrease-qty">-</button>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>">
                                <button type="button" class="btn btn-sm" id="increase-qty">+</button>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-block">
                            <button type="submit" name="add_to_cart" class="btn btn-primary add-to-cart-btn" <?= $product['stock'] <= 0 ? 'disabled' : '' ?>>
                                <i class="fas fa-shopping-cart"></i> Ajouter 
                            </button>
                            <br>
                            <br>
                            <button type="button" class="btn btn-outline-primary ms-md-2 add-to-wishlist-btn">
                                <i class="far fa-heart"></i> Favoris 
                            </button>
                        </div>
                    </form>
                    
                    <!-- Product Information Accordions -->
                    <div class="mt-5">
                        <div class="product-info-section border-bottom py-3">
                            <h5 data-toggle="collapse" data-target="#productInfo">
                                Information de produit <i class="fas fa-chevron-down toggle-icon"></i>
                            </h5>
                            <div class="product-info-content" id="productInfo">
                                <ul>
                                    <li><strong>Material:</strong> Handcrafted with natural clay</li>
                                    <li><strong>Origin:</strong> Made in Tunisia</li>
                                    <?php if ($product['created_at']): ?>
                                        <li><strong>Added:</strong> <?= date('F j, Y', strtotime($product['created_at'])) ?></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>                                
                    </div>
                </div>
            </div>
            
            <!-- Related Products Section -->
            <div class="related-products mt-5">
                <h3 class="text-center mb-4">Vous pourriez être intéressé</h3>
                <hr class="mx-auto" style="width: 60px; border: 2px solid #fcd34d">
                
                <div class="product-carousel-container">
                    <button class="carousel-arrow prev-arrow"><i class="fas fa-chevron-left"></i></button>
                    <button class="carousel-arrow next-arrow"><i class="fas fa-chevron-right"></i></button>
                    
                    <div class="product-carousel">
                        <?php
                        // Get related products (same category or featured products)
                        $relatedQuery = $db->prepare("SELECT * FROM product 
                                                    WHERE category_id = ? AND id_product != ? 
                                                    LIMIT 4");
                        $relatedQuery->execute([$product['category_id'], $product_id]);
                        $relatedProducts = $relatedQuery->fetchAll(PDO::FETCH_ASSOC);
                        
                        // If not enough related products, get some best sellers
                        if (count($relatedProducts) < 4) {
                            $bestSellersQuery = $db->prepare("SELECT * FROM product 
                                                            WHERE is_best_seller = 1 AND id_product != ? 
                                                            LIMIT ?");
                            $bestSellersQuery->execute([$product_id, 4 - count($relatedProducts)]);
                            $bestSellers = $bestSellersQuery->fetchAll(PDO::FETCH_ASSOC);
                            $relatedProducts = array_merge($relatedProducts, $bestSellers);
                        }
                        
                        foreach($relatedProducts as $relatedProduct): ?>
                            <div class="product-card">
                                <div class="wishlist-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="product-image">
                                    <a href="product-detail.php?id=<?= $relatedProduct['id_product'] ?>">
                                        <img src="./uploads/products/<?= htmlspecialchars($relatedProduct['image']) ?>" 
                                             alt="<?= htmlspecialchars($relatedProduct['title']) ?>">
                                    </a>
                                </div>
                                <div class="product-details">
                                    <div class="d-flex justify-content-between">
                                        <h5><?= htmlspecialchars($relatedProduct['title']) ?></h5>
                                        <span class="price"><?= number_format($relatedProduct['price'], 2) ?> DT</span>
                                    </div>
                                    <p class="product-description"><?= substr(htmlspecialchars($relatedProduct['description']), 0, 80) ?>...</p>
                                    <div class="product-btn-container">
                                        <a href="product-detail.php?id=<?= $relatedProduct['id_product'] ?>" class="btn btn-primary add-to-cart-btn">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include './assets/templates/footer.php'; ?>

    <!-- Back to Top Button -->
    <button id="backToTop" class="tunisian-scroll-top" style="display: none;">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Back to Top Button Script
    window.addEventListener('scroll', function() {
        var backToTopButton = document.getElementById('backToTop');
        if (window.pageYOffset > 300) {
            backToTopButton.style.display = 'flex';
        } else {
            backToTopButton.style.display = 'none';
        }
    });
    document.getElementById('backToTop').addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Quantity selector
    document.getElementById('decrease-qty').addEventListener('click', function() {
        var input = document.getElementById('quantity');
        var value = parseInt(input.value);
        if (value > 1) {
            input.value = value - 1;
        }
    });

    document.getElementById('increase-qty').addEventListener('click', function() {
        var input = document.getElementById('quantity');
        var value = parseInt(input.value);
        var max = parseInt(input.getAttribute('max'));
        if (value < max) {
            input.value = value + 1;
        }
    });

    // Toggle accordion content
    document.querySelectorAll('.product-info-section h5, .product-tags-section h5').forEach(function(element) {
        element.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            var content = document.querySelector(targetId);
            content.classList.toggle('show');
            
            // Toggle icon
            var icon = this.querySelector('.toggle-icon');
            if (icon.classList.contains('fa-chevron-down')) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        });
    });

    // Product carousel
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.querySelector('.product-carousel');
        const prevBtn = document.querySelector('.prev-arrow');
        const nextBtn = document.querySelector('.next-arrow');
        const cardWidth = 300; // Width of each card + margin
        let position = 0;
        
        // Handle next button click
        nextBtn.addEventListener('click', function() {
            const maxPosition = carousel.scrollWidth - carousel.clientWidth;
            position = Math.min(position + cardWidth, maxPosition);
            carousel.style.transform = `translateX(-${position}px)`;
            updateArrowStatus();
        });
        
        // Handle prev button click
        prevBtn.addEventListener('click', function() {
            position = Math.max(position - cardWidth, 0);
            carousel.style.transform = `translateX(-${position}px)`;
            updateArrowStatus();
        });
        
        // Update arrow status based on position
        function updateArrowStatus() {
            prevBtn.classList.toggle('disabled', position === 0);
            nextBtn.classList.toggle('disabled', position >= carousel.scrollWidth - carousel.clientWidth);
        }
        
        // Initial status update
        updateArrowStatus();
    });
    </script>
</body>
</html>