<?php 
session_start();

// Database connection
require_once __DIR__ . '/../../config/init.php';

$db = Database::getInstance();

$page_title = "Catégories - E-Souk Tounsi";
$page_description = "Découvrez toutes nos catégories d'artisanat tunisien";

// Fetch all categories from database
$stmt = $db->query("SELECT * FROM category ORDER BY id_category");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="../assets/css/categories.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    
    
</head>
<body>
    <?php include '../templates/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="categories-hero">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Nos Catégories</h1>
            <p class="lead">Découvrez notre sélection d'artisanat tunisien authentique</p>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="container category-container">
    <?php if (empty($categories)): ?>
        <div class="alert alert-info text-center">Aucune catégorie n'est disponible pour le moment.</div>
    <?php else: ?>
        <?php 
        $count = 0;
        foreach ($categories as $category): 
            $isEven = $count % 2 == 0;
            
            // Start a new row for every two categories
            if ($count % 2 == 0):
        ?>
        <div class="row category-row align-items-center">
            <?php if ($isEven): ?>
            <div class="decoration-shape shape-1"></div>
            <?php else: ?>
            <div class="decoration-shape shape-2"></div>
            <?php endif; ?>
        <?php endif; ?>
            
            <?php if ($isEven): ?>
            <!-- Left aligned category -->
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="category-card">
                    <?php if (!empty($category['image'])): ?>
                        <img src="../uploads/categories/<?= htmlspecialchars($category['image']) ?>" alt="<?= htmlspecialchars($category['name']) ?>" class="category-image">
                    <?php else: ?>
                        <img src="../assets/images/category-placeholder.jpg" alt="<?= htmlspecialchars($category['name']) ?>" class="category-image">
                    <?php endif; ?>
                    <div class="category-overlay">
                        <h3 class="category-title"><?= htmlspecialchars($category['name']) ?></h3>
                        <p class="category-desc">Découvrez nos <?= strtolower(htmlspecialchars($category['name'])) ?> traditionnels tunisiens</p>
                        <a href="category.php?id=<?= $category['id_category'] ?>" class="category-btn">Découvrir</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5 offset-md-1">
                <h2 class="mb-3"><?= htmlspecialchars($category['name']) ?></h2>
                <hr class="w-25" style="border: 2px solid #fcd34d">
                <p class="lead">
                    L'artisanat tunisien est renommé pour ses <?= strtolower(htmlspecialchars($category['name'])) ?> 
                    authentiques créés à la main par des artisans qui perpétuent des techniques ancestrales.
                </p>
                <a href="category.php?id=<?= $category['id_category'] ?>" class="btn btn-outline-primary mt-3">
                    Explorer <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
            <?php else: ?>
            <!-- Right aligned category -->
            <div class="col-md-5">
                <h2 class="mb-3"><?= htmlspecialchars($category['name']) ?></h2>
                <hr class="w-25" style="border: 2px solid #fcd34d">
                <p class="lead">
                    Chaque <?= strtolower(htmlspecialchars($category['name'])) ?> raconte une histoire unique 
                    issue du riche patrimoine culturel tunisien et témoigne d'un savoir-faire exceptionnel.
                </p>
                <a href="category.php?id=<?= $category['id_category'] ?>" class="btn btn-outline-primary mt-3">
                    Explorer <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="col-md-6 offset-md-1">
                <div class="category-card">
                    <?php if (!empty($category['image'])): ?>
                        <img src="../uploads/categories/<?= htmlspecialchars($category['image']) ?>" alt="<?= htmlspecialchars($category['name']) ?>" class="category-image">
                    <?php else: ?>
                        <img src="../assets/images/category-placeholder.jpg" alt="<?= htmlspecialchars($category['name']) ?>" class="category-image">
                    <?php endif; ?>
                    <div class="category-overlay">
                        <h3 class="category-title"><?= htmlspecialchars($category['name']) ?></h3>
                        <p class="category-desc">Découvrez nos <?= strtolower(htmlspecialchars($category['name'])) ?> artisanaux faits à la main</p>
                        <a href="category.php?id=<?= $category['id_category'] ?>" class="category-btn">Découvrir</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
        <?php 
            // Close the row if it's the last category or after every two categories
            if ($count % 2 == 1 || $count == count($categories) - 1):
        ?>
        </div>
        <?php endif; ?>
        
        <?php 
            $count++;
        endforeach; 
        ?>
    <?php endif; ?>
    </section>


    <?php include '../templates/Topbtn.php'; ?>
     <?php include '../templates/newsletter.php'; ?>
    <?php include '../templates/footer.php'; ?>

</body>
</html>