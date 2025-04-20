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
                <h1 class="hero-title mb-4">Découvrez le Meilleur<br>de l'Artisanat Tunisien</h1>
                <p class="hero-subtitle mb-4">Des pièces uniques faites à la main par nos artisans locaux qui perpétuent un héritage ancestral.</p>
                <div class="hero-buttons">
                    <a href="product.php" class="btn btn-primary btn-lg px-4 shadow-sm">Explorer les produits</a>
                    <a href="artisans.php" class="btn btn-outline-light btn-lg px-4 ms-3">Nos artisans</a>
                </div>
            </div>
            <div class="col-lg-6 position-relative z-2 d-none d-lg-block">
                <div class="hero-featured-product">
                    <img src="./assets/images/featured-product.png" alt="Produit artisanal mis en avant" class="img-fluid rounded-lg shadow-lg">
                    <div class="hero-badge">
                        <span>Nouveauté</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-shape">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#ffffff" fill-opacity="1" d="M0,160L48,170.7C96,181,192,203,288,197.3C384,192,480,160,576,149.3C672,139,768,149,864,181.3C960,213,1056,267,1152,261.3C1248,256,1344,192,1392,160L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>
<!-- Updated Image Section in index.php -->
<!-- Replace your current image section with this code -->

<!-- Image Section -->
<section class="artisan-showcase">
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-md-6">
                <div class="artisan-image-container">
                    <img src="./assets/images/historic/2.jpg" alt="artisan" class="img-fluid">
                    <div class="artisan-overlay">
                        <div class="artisan-info">
                            <h3>L'Art de l'Artisanat</h3>
                            <p>Des techniques transmises de génération en génération</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="artisan-text-container">
                    <div class="artisan-text-content">
                        <span class="artisan-badge">Notre Histoire</span>
                        <h2>Une Tradition Ancestrale</h2>
                        <p>L'artisanat tunisien est le reflet d'un patrimoine culturel riche et diversifié. Chaque pièce raconte une histoire et témoigne d'un savoir-faire transmis à travers les âges.</p>
                        <p>Nos artisans perpétuent ces techniques ancestrales tout en apportant leur touche de créativité pour créer des pièces uniques qui allient tradition et modernité.</p>
                        <a href="artisans.php" class="btn btn-outline-primary">Découvrir nos artisans</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Featured Categories -->
    <section class="container mb-5 py-4">
        <h2 class="text-center mb-5">Nos Catégories</h2>
        <hr class="mx-auto" style="width: 60px; border: 2px solid #fcd34d">
        <br>
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
    <hr class="mx-auto" style="width: 60px; border: 2px solid #fcd34d">
    
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

       <!-- Back to Top Button -->
   <button id="backToTop" class="tunisian-scroll-top" style="display: none;">
       <i class="fas fa-chevron-up"></i>
   </button>
   <!-- Scripts -->
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
   </script>
</body>
</html>
