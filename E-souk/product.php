<?php
require_once 'connection.php';
$db = Database::getInstance();

// Initialize filter variables
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : null;
$priceMin = isset($_GET['price_min']) ? (int)$_GET['price_min'] : 0;
$priceMax = isset($_GET['price_max']) ? (int)$_GET['price_max'] : 500;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';

// Get categories for filter properly
$categories = [];
$categoryQuery = "SELECT id_category, name FROM category ORDER BY name";
$categoryStmt = $db->prepare($categoryQuery);
$categoryStmt->execute();
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

// Build product query with filters
$query = "SELECT p.*, c.name as category_name 
          FROM product p
          LEFT JOIN category c ON p.category_id = c.id_category
          WHERE 1=1";

// Add category filter if selected
if ($categoryFilter) {
    $query .= " AND p.category_id = :category_id";
}

// Add price filter
$query .= " AND p.price BETWEEN :price_min AND :price_max";

// Add sorting
switch ($sort) {
    case 'price_asc':
        $query .= " ORDER BY p.price ASC";
        break;
    case 'price_desc':
        $query .= " ORDER BY p.price DESC";
        break;
    case 'newest':
        $query .= " ORDER BY p.id_product DESC";
        break;
    default:
        $query .= " ORDER BY p.title ASC";
}

// Prepare and execute the query
$stmt = $db->prepare($query);
if ($categoryFilter) {
    $stmt->bindParam(':category_id', $categoryFilter, PDO::PARAM_INT);
}
$stmt->bindParam(':price_min', $priceMin, PDO::PARAM_INT);
$stmt->bindParam(':price_max', $priceMax, PDO::PARAM_INT);
$stmt->execute();
$filtered_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tous les Produits - E-souk Tounsi</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Favicon -->
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./assets/css/styles.css" />
</head>
<body>
    <?php include "./assets/templates/navbar.php"; ?>

    <!-- Breadcrumb -->
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home"></i> Accueil</a></li>
                <li class="breadcrumb-item"><a href="category.php">Catégories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tous les produits</li>
            </ol>
        </nav>
    </div>

    <!-- Main Products Section -->
    <section class="container py-5">
        <div class="row">
            <!-- Filters Column -->
            <div class="col-lg-3 mb-4">
                <div class="filter-section">
                    <h5 class="mb-4">Filtrer les produits</h5>

                   <!-- Categories Filter -->
                    <div class="mb-4">
                        <h6>Catégories</h6>
                        <?php foreach ($categories as $category): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                name="category[]" 
                                id="cat_<?php echo $category['id_category']; ?>" 
                                value="<?php echo $category['id_category']; ?>"
                                <?php echo ($categoryFilter == $category['id_category']) ? 'checked' : ''; ?> />
                            <label class="form-check-label" for="cat_<?php echo $category['id_category']; ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Price Filter -->
                    <div class="mb-4">
                        <h6>Prix</h6>
                        <div class="d-flex justify-content-between">
                            <span>0 DT</span>
                            <span>500 DT</span>
                        </div>
                        <input type="range" class="form-range" min="0" max="500" step="10" id="priceRange" />
                    </div>

                    <!-- Size Filter -->
                    <div class="mb-4">
                        <h6>Taille</h6>
                        <div class="btn-group btn-group-sm" role="group">
                            <input type="radio" class="btn-check" name="size" id="size-all" autocomplete="off" checked />
                            <label class="btn btn-outline-secondary" for="size-all">Tous</label>

                            <input type="radio" class="btn-check" name="size" id="size-s" autocomplete="off" />
                            <label class="btn btn-outline-secondary" for="size-s">S</label>

                            <input type="radio" class="btn-check" name="size" id="size-m" autocomplete="off" />
                            <label class="btn btn-outline-secondary" for="size-m">M</label>

                            <input type="radio" class="btn-check" name="size" id="size-l" autocomplete="off" />
                            <label class="btn btn-outline-secondary" for="size-l">L</label>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100">Appliquer les filtres</button>
                </div>
            </div>

            <!-- Products Column -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Tous nos produits artisanaux</h2>
                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown">
                            Trier par: Pertinence
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Pertinence</a></li>
                            <li><a class="dropdown-item" href="#">Prix croissant</a></li>
                            <li><a class="dropdown-item" href="#">Prix décroissant</a></li>
                            <li><a class="dropdown-item" href="#">Plus récents</a></li>
                            <li><a class="dropdown-item" href="#">Meilleures notes</a></li>
                        </ul>
                    </div>
                </div>

              <!-- Product Grid -->
<div class="row g-4">
    <?php if (count($filtered_products) > 0): ?>
        <?php foreach ($filtered_products as $product): ?>
        <div class="col-md-4 col-6">
            <div class="card h-100 product-card">
                <?php if (isset($product['is_best_seller']) && $product['is_best_seller']): ?>
                <span class="badge bg-danger">Best Seller</span>
                <?php endif; ?>
                <a href="product-detail.php?id=<?php echo $product['id_product']; ?>">
                    <img src="./uploads/products/<?php echo htmlspecialchars($product['image']); ?>" 
                         class="card-img-top" 
                         alt="<?php echo htmlspecialchars($product['title']); ?>" />
                </a>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($product['title']); ?></h5>
                    <p class="card-text small text-muted">
                        <?php echo htmlspecialchars(substr($product['description'], 0, 50)); ?>...
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-primary fw-bold"><?php echo number_format($product['price'], 2); ?> DT</span>
                        <span class="badge bg-<?php echo ($product['stock'] > 0) ? 'success' : 'danger'; ?>">
                            <?php echo ($product['stock'] > 0) ? 'En stock' : 'Épuisé'; ?>
                        </span>
                    </div>
                    <button class="btn btn-dark w-100 mt-2" onclick="addToCart(<?php echo $product['id_product']; ?>)">
                        Ajouter au panier
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-info">
                Aucun produit ne correspond à vos critères de recherche.
            </div>
        </div>
    <?php endif; ?>
</div>

                <!-- Pagination -->
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Précédent</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Suivant</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

    <?php include "./assets/templates/footer.php"; ?>
    
   
    <script>
    function addToCart(productId) {
        // AJAX request to add item to cart
        console.log('Adding product ID ' + productId + ' to cart');
        // Implement AJAX call here
    }
    </script>

    
</body>
</html>
