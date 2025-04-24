<?php 
session_start(); // Add this line if not already included in init.php
require_once __DIR__ . '/../../config/init.php';
require_once ROOT_PATH . '/core/connection.php';
$db = Database::getInstance();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: ../user/login.php?redirect=../pages/wishlist.php'); // Fix login path
  exit;
}

$user_id = $_SESSION['user_id'];
$page_title = "Artisanat Tunisien - Favoris";
$page_description = "Découvrez votre sélection de produits artisanaux tunisiens dans votre liste de favoris.";


$query = $db->prepare("
  SELECT w.id_wishlist as wishlist_id, p.id_product as id, p.title as name, p.description, p.price, p.stock, p.image
  FROM wishlist w
  JOIN product p ON w.product_id = p.id_product
  WHERE w.user_id = ?");
$query->execute([$user_id]);
$wishlist_items = $query->fetchAll(PDO::FETCH_ASSOC);
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
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
  <?php include '../templates/navbar.php'; ?> 

  <!-- Wishlist Section -->
  <section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Mes Favoris</h2>
      <?php if(count($wishlist_items) > 0): ?>
      <a href="cart.php?add_all_wishlist=1" class="btn btn-outline-primary">
        <i class="fas fa-shopping-cart me-2"></i>Tout ajouter au panier
      </a>
      <?php endif; ?>
    </div>
    <hr class="mb-4">

    <?php if(count($wishlist_items) > 0): ?>
      <div class="row g-4">
        <?php foreach($wishlist_items as $item): ?>
          <div class="col-lg-3 col-md-4 col-6">
            <div class="card h-100 border-0 shadow-sm product-card position-relative">
              <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-wishlist" 
                  data-id="<?= $item['wishlist_id'] ?>">
                <i class="fas fa-times"></i>
              </button>
              <a href="product-detail.php?id=<?= $item['id'] ?>">
                <img src="<?= !empty($item['image_path']) ? '../' . $item['image_path'] : 'https://via.placeholder.com/300x300?text=Produit' ?>" 
                   class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>">
              </a>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                <p class="text-primary fw-bold mb-3"><?= number_format($item['price'], 2) ?> DT</p>
                
                <?php if($item['stock'] > 0): ?>
                  <button class="btn btn-dark mt-auto add-to-cart" 
                      data-id="<?= $item['id'] ?>">
                    Ajouter au panier
                  </button>
                <?php else: ?>
                  <button class="btn btn-secondary mt-auto" disabled>
                    Rupture de stock
                  </button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="text-center py-5">
        <i class="fas fa-heart-broken fa-4x text-muted mb-3"></i>
        <h3>Votre liste de favoris est vide</h3>
        <p class="text-muted mb-4">Découvrez notre collection et ajoutez des produits à vos favoris</p>
        <a href="product.php" class="btn btn-primary">Parcourir nos produits</a>
      </div>
    <?php endif; ?>

  
  </section>

  
 

  <?php include '../templates/footer.php'; ?>
 
  <script>

  
  // Remove from wishlist
  document.querySelectorAll('.remove-wishlist').forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      const id = this.dataset.id;
      
      fetch('ajax/wishlist.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          action: 'remove',
          wishlist_id: id
        })
      })
      .then(response => response.json())
      .then(data => {
        if(data.success) {
          this.closest('.col-lg-3').remove();
          if(document.querySelectorAll('.product-card').length === 0) {
            location.reload();
          }
        }
      });
    });
  });
  
  // Add to cart
  document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
      const id = this.dataset.id;
      
      fetch('ajax/cart.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          action: 'add',
          product_id: id,
          quantity: 1
        })
      })
      .then(response => response.json())
      .then(data => {
        if(data.success) {
          this.innerHTML = '<i class="fas fa-check me-2"></i>Ajouté';
          this.classList.replace('btn-dark', 'btn-success');
          
          setTimeout(() => {
            this.innerHTML = 'Ajouter au panier';
            this.classList.replace('btn-success', 'btn-dark');
          }, 2000);
          
          // Update cart count in navbar if needed
          if(data.cart_count && document.getElementById('cart-count')) {
            document.getElementById('cart-count').textContent = data.cart_count;
          }
        }
      });
    });
  });
  </script>
 
</body>

</html>
