<?php 
session_start();

$page_title = "Panier - E-Souk Tounsi";
$page_description = "Consultez et gérez les articles dans votre panier d'achat. Finalisez votre commande d'artisanat tunisien authentique.";
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

    <!-- Cart Section -->
    <section class="container py-5">
        <h2 class="mb-4 text-center">Mon Panier</h2>
        <hr class="mx-auto" style="width: 60px; border: 2px solid #fcd34d">

        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Cart Items -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <!-- Sample Cart Item -->
                        <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                            <div class="flex-shrink-0">
                                <img src="https://via.placeholder.com/100x100?text=Produit" alt="Produit" class="img-fluid rounded" style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-1">Produit Artisanal</h5>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                </div>
                                <p class="text-muted mb-2">Catégorie: Céramique</p>
                                <div class="d-flex align-items-center">
                                    <div class="input-group input-group-sm me-3" style="width: 120px;">
                                        <button class="btn btn-outline-secondary" type="button">-</button>
                                        <input type="text" class="form-control text-center" value="1" readonly>
                                        <button class="btn btn-outline-secondary" type="button">+</button>
                                    </div>
                                    <p class="text-primary fw-bold mb-0">90 DT</p>
                                </div>
                            </div>
                        </div>

                        <!-- Sample Cart Item -->
                        <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                            <div class="flex-shrink-0">
                                <img src="https://via.placeholder.com/100x100?text=Produit" alt="Produit" class="img-fluid rounded" style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-1">Accessoire Chic</h5>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                </div>
                                <p class="text-muted mb-2">Catégorie: Accessoires</p>
                                <div class="d-flex align-items-center">
                                    <div class="input-group input-group-sm me-3" style="width: 120px;">
                                        <button class="btn btn-outline-secondary" type="button">-</button>
                                        <input type="text" class="form-control text-center" value="2" readonly>
                                        <button class="btn btn-outline-secondary" type="button">+</button>
                                    </div>
                                    <p class="text-primary fw-bold mb-0">75 DT</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-start">
                    <a href="product.php" class="btn btn-outline-primary">Continuer vos achats</a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="mb-4">Résumé de la commande</h4>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Sous-total</span>
                            <span>240 DT</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Frais de livraison</span>
                            <span>15 DT</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span>255 DT</span>
                        </div>
                        <button class="btn btn-primary w-100 mt-4">Passer la commande</button>
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