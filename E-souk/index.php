<?php 
session_start();


$page_title = "Accueil - E-Souk Tounsi";
$page_description = "Découvrez l'artisanat tunisien de qualité";



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
    <?php include './assets/templates/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section position-relative mb-5">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="row align-items-center" style="min-height: 80vh">
                <div class="col-lg-6 text-white position-relative z-2">
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2">Artisanat authentique</span>
                    <h1 class="display-3 fw-bold mb-3">Découvrez le Meilleur<br>de l'Artisanat Tunisien</h1>
                    <p class="lead mb-4">Des pièces uniques faites à la main par nos artisans locaux qui perpétuent un héritage ancestral.</p>
                    <div class="d-flex gap-3">
                        <a href="#products" class="btn btn-primary btn-lg px-4 shadow-sm">Explorer les produits</a>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="curved-bottom">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100">
                <path fill="#4d5ae6" fill-opacity="1" d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,100L1360,100C1280,100,1120,100,960,100C800,100,640,100,480,100C320,100,160,100,80,100L0,100Z"></path>
            </svg>
        </div>
    </section>

    <!-- Image Section -->
    <section class="image mb-2">
        <div class="container">
            <div class="block-image sc-2" style="/*position in column */  " >
                <img src="./assets/images/historic/2.jpg" alt="artisan" class="img-fluid">
            </div>
           
    </section>

    <!-- Featured Categories -->
    <section class="container mb-5 py-4">
        <h2 class="text-center mb-5">Nos Catégories</h2>
        <div class="category-container">
            <div class="category-card category-start">
                <div class="category-image-container">
                    <img src="./assets/images/Accessories.jpg" alt="Accessories">
                    <div class="category-overlay">
                        <h5>Accessories</h5>
                        <p>Découvrez notre collection d'accessoires artisanaux.</p>
                        <a href="category.php?id=1" class="category-btn">Découvrir</a>
                    </div>
                </div>
            </div>

            <div class="category-card category-end">
                <div class="category-image-container">
                    <img src="./assets/images/klim.jpg" alt="Rugs & Kilim">
                    <div class="category-overlay">
                        <h5>Rugs & Kilim</h5>
                        <p>Explorez nos tapis et kilims traditionnels faits à la main.</p>
                        <a href="category.php?id=2" class="category-btn">Découvrir</a>
                    </div>
                </div>
            </div>
            
            <div class="category-card category-start">
                <div class="category-image-container">
                    <img src="./assets/images/Handcrafted-ceramic.jpg" alt="Handcrafted Ceramics">
                    <div class="category-overlay">
                        <h5>Handcrafted Ceramics</h5>
                        <p>Découvrez notre collection de céramiques artisanales tunisiennes faites à la main.</p>
                        <a href="category.php?id=3" class="category-btn">Découvrir</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <p class="lead">Découvrez toutes nos catégories d'artisanat tunisien traditionnel</p>
            <a href="categories.php" class="btn btn-primary px-4 py-2">Voir toutes les catégories</a>
        </div>

    </section>

<!-- Products Carousel -->
<section id="products" class="container-fluid mb-5 py-5 bg-light">
    <h2 class="text-center mb-5">Nos Best-Sellers</h2>
    
    <div class="product-carousel-container">
        <!-- Navigation arrows -->
        <button class="carousel-arrow prev-arrow"><i class="fas fa-chevron-left"></i></button>
        <button class="carousel-arrow next-arrow"><i class="fas fa-chevron-right"></i></button>
        
        <div class="product-carousel">
            <?php
            // Get all products and store in array
            $productsQuery = $db->query("SELECT * FROM product WHERE is_best_seller = 1 LIMIT 8");
            $productsArray = $productsQuery->fetchAll(PDO::FETCH_ASSOC);
            
            // Display main products
            foreach($productsArray as $product): ?>
                <div class="product-card">
                    <div class="wishlist-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="product-image">
                        <img src="./uploads/products/<?= htmlspecialchars($product['image']) ?>" 
                             alt="<?= htmlspecialchars($product['title']) ?>">
                    </div>
                    <div class="product-details">
                        <div class="d-flex justify-content-between">
                            <h5><?= htmlspecialchars($product['title']) ?></h5>
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
            <?php endforeach; ?>
        </div>
    </div>
</section>

    <!-- Newsletter -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <h3 class="mb-3">Recevez nos dernières nouveautés</h3>
                    <form class="row g-2" action="newsletter.php" method="POST">
                        <div class="col-8">
                            <input type="email" name="email" class="form-control" placeholder="Votre email" required>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-dark w-100">S'abonner</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include './assets/templates/footer.php'; ?>

    <!-- Back to Top Button Script -->
    <script>
    document.getElementById('backToTop').addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    </script>
</body>
</html>
