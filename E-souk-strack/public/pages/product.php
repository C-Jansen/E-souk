<?php
require_once __DIR__ . '/../../config/init.php';

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
$page_title = "Tous les produits artisanaux";
$page_description = "Découvrez notre sélection de produits artisanaux uniques et faits main. Parcourez nos catégories et trouvez le produit parfait pour vous ou un proche.";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include "../templates/header.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.js"></script>
    <style>
.noUi-connect {
    background: var(--bs-primary);
}
.noUi-handle {
    border-radius: 50%;
    background: #fff;
    border: 2px solid var(--bs-primary);
    box-shadow: none;
    cursor: pointer;
}
.noUi-handle:focus {
    outline: none;
}
.noUi-horizontal {
    height: 8px;
}
.noUi-horizontal .noUi-handle {
    width: 18px;
    height: 18px;
    top: -5px;
    right: -9px;
}
/* Remove the default handle styling */
.noUi-handle:before, .noUi-handle:after {
    display: none;
}
</style>
</head>
<body>
    <?php include "../templates/navbar.php"; ?>

    <!-- Breadcrumb -->
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home"></i> Accueil</a></li>
                <li class="breadcrumb-item"><a href="category-details.php">Catégories</a></li>
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
                    
                    <form id="filterForm" method="GET" action="">
                        <!-- Categories Filter -->
                        <div class="mb-4">
                            <h6>Catégories</h6>
                            <?php foreach ($categories as $category): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" 
                                    name="category" 
                                    id="cat_<?php echo $category['id_category']; ?>" 
                                    value="<?php echo $category['id_category']; ?>"
                                    <?php echo ($categoryFilter == $category['id_category']) ? 'checked' : ''; ?> />
                                <label class="form-check-label" for="cat_<?php echo $category['id_category']; ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                            <!-- Add option to show all categories -->
                            <div class="form-check">
                                <input class="form-check-input" type="radio" 
                                    name="category" 
                                    id="cat_all" 
                                    value=""
                                    <?php echo ($categoryFilter === null) ? 'checked' : ''; ?> />
                                <label class="form-check-label" for="cat_all">
                                    Toutes les catégories
                                </label>
                            </div>
                        </div>

                        <!-- Price Filter with Range Slider -->
                        <div class="mb-4">
                            <h6>Prix</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span id="priceMinValue"><?php echo $priceMin; ?> DT</span>
                                <span id="priceMaxValue"><?php echo $priceMax; ?> DT</span>
                            </div>
                            <div id="priceRangeSlider" class="mt-2"></div>
                            <!-- Hidden inputs to store the values -->
                            <input type="hidden" id="priceMinRange" name="price_min" value="<?php echo $priceMin; ?>">
                            <input type="hidden" id="priceMaxRange" name="price_max" value="<?php echo $priceMax; ?>">
                        </div>
                        
                        <!-- Sort option (hidden field updated by dropdown) -->
                        <input type="hidden" name="sort" id="sortInput" value="<?php echo $sort; ?>">
                        
                        <button type="submit" class="btn btn-primary w-100">Appliquer les filtres</button>
                    </form>
                </div>
            </div>

            <!-- Products Column -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Tous nos produits artisanaux</h2>


                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown">
                            Trier par: <?php echo getSortLabel($sort); ?>
                        </button>
                        
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item sort-option" data-sort="default" href="#">Pertinence</a></li>
                            <li><a class="dropdown-item sort-option" data-sort="price_asc" href="#">Prix croissant</a></li>
                            <li><a class="dropdown-item sort-option" data-sort="price_desc" href="#">Prix décroissant</a></li>
                            <li><a class="dropdown-item sort-option" data-sort="newest" href="#">Plus récents</a></li>
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
                    <img src="../../root_uploads/products/<?php echo htmlspecialchars($product['image']); ?>" 
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

    <?php include "../templates/Topbtn.php"; ?>
    <?php include "../templates/newsletter.php"; ?>
    <?php include "../templates/footer.php"; ?>
    
   
    <script>
// For price range slider
document.addEventListener('DOMContentLoaded', function() {
    // Price range slider
    const priceSlider = document.getElementById('priceRangeSlider');
    const priceMinValue = document.getElementById('priceMinValue');
    const priceMaxValue = document.getElementById('priceMaxValue');
    const priceMinInput = document.getElementById('priceMinRange');
    const priceMaxInput = document.getElementById('priceMaxRange');
    
    if (priceSlider) {
        noUiSlider.create(priceSlider, {
            start: [<?php echo $priceMin; ?>, <?php echo $priceMax; ?>],
            connect: true,
            step: 10,
            range: {
                'min': 0,
                'max': 500
            },
            format: {
                to: function (value) {
                    return Math.round(value);
                },
                from: function (value) {
                    return Math.round(value);
                }
            }
        });
        
        // Update values when slider is moved
        priceSlider.noUiSlider.on('update', function (values, handle) {
            const value = values[handle];
            if (handle === 0) {
                priceMinValue.textContent = value + ' DT';
                priceMinInput.value = value;
            } else {
                priceMaxValue.textContent = value + ' DT';
                priceMaxInput.value = value;
            }
        });
    }
    
    // The rest of your existing code for sort options...
    const sortOptions = document.querySelectorAll('.sort-option');
    const sortInput = document.getElementById('sortInput');
    
    sortOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const sortValue = this.getAttribute('data-sort');
            sortInput.value = sortValue;
            document.getElementById('filterForm').submit();
        });
    });
});

// Global function for add to cart
function addToCart(productId) {
    // AJAX request to add item to cart
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `product_id=${productId}&quantity=1`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Produit ajouté au panier');
            // Update cart count if needed
            if (data.cart_count) {
                const cartBadge = document.querySelector('.cart-count');
                if (cartBadge) cartBadge.textContent = data.cart_count;
            }
        } else {
            alert(data.message || 'Erreur lors de l\'ajout au panier');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur s\'est produite');
    });
}
</script>

    
</body>
</html>

<?php
// Helper function to get sort label
function getSortLabel($sort) {
    switch ($sort) {
        case 'price_asc':
            return 'Prix croissant';
        case 'price_desc':
            return 'Prix décroissant';
        case 'newest':
            return 'Plus récents';
        default:
            return 'Pertinence';
    }
}
?>
