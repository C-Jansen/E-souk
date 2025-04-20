<?php 
$page_title = "Artisanat Tunisien - Wishlist";
$page_description = "Découvrez notre sélection de produits artisanaux tunisiens dans votre liste de souhaits. Ajoutez vos articles préférés et passez à l'achat facilement.";
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



    <!-- Hero Section -->    <!-- Wishlist Section -->
    <section class="container py-5">
      <h2 class="mb-4 text-center">Ma Wishlist</h2>
              <hr class="mx-auto" style="width: 60px; border: 2px solid #fcd34d">


      <div class="row g-4">
        <!-- Product 1 -->
        <div class="col-md-4 col-6">
          <div class="card h-100 border-0 shadow-sm position-relative">
            <button
              class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
            >
              <i class="fas fa-times"></i>
            </button>
            <img
              src="https://via.placeholder.com/300x300?text=Produit+1"
              class="card-img-top"
              alt="Produit"
            />
            <div class="card-body">
              <h5 class="card-title">Produit Favori</h5>
              <p class="text-primary fw-bold">90 DT</p>
              <button class="btn btn-dark w-100">Ajouter au panier</button>
            </div>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="col-md-4 col-6">
          <div class="card h-100 border-0 shadow-sm position-relative">
            <button
              class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
            >
              <i class="fas fa-times"></i>
            </button>
            <img
              src="https://via.placeholder.com/300x300?text=Produit+2"
              class="card-img-top"
              alt="Produit"
            />
            <div class="card-body">
              <h5 class="card-title">Accessoire Chic</h5>
              <p class="text-primary fw-bold">75 DT</p>
              <button class="btn btn-dark w-100">Ajouter au panier</button>
            </div>
          </div>
        </div>

        <!-- You can add more products using the same pattern -->
      </div>

      <div class="text-center mt-5">
        <a href="tous_produits.html" class="btn btn-outline-primary"
          >Continuer vos achats</a
        >
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
