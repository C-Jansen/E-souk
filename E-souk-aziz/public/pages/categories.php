<?php 
session_start();

// Database connection
require_once __DIR__ . '/../../config/init.php';

$page_title = "Catégories - E-Souk Tounsi";
$page_description = "Découvrez toutes nos catégories d'artisanat tunisien";

// Initialize categories array
$categories = [];

try {
    // Only select the columns we need for better performance
    $query = "SELECT id_category, name, description, image FROM category ORDER BY id_category";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    // Store the fetched results in the $categories variable
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Log empty results for debugging
    if (empty($categories)) {
        error_log("No categories found in the database");
    }
} catch (PDOException $e) {
    // Log the error and set a user-friendly message
    error_log("Database error: " . $e->getMessage());
    $error_message = "Une erreur est survenue lors de la récupération des catégories.";
}
//print image path for debugging
//error_log("Image path: " . __DIR__ . "/../../root_uploads/" . $category['image']);
error_log("Image path: " . ROOT_PATH . '/../../root_uploads/categories/' .htmlspecialchars($categories[0]['image']));

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include '../templates/header.php'; ?>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/categories.css">
</head>
<body>
    <?php include '../templates/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="categories-hero">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Nos Categories</h1>
            <p class="lead">Découvrez notre sélection d'artisanat tunisien authentique</p>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="container category-container my-5">
        <?php if (empty($categories)): ?>
            <div class="alert alert-info text-center">Aucune catégorie n'est disponible pour le moment.</div>
        <?php else: ?>
            <?php foreach ($categories as $index => $category): 
                $isEven = $index % 2 == 0;
                
                // Add decorative shape
                if ($index % 2 == 0): ?>
                    <div class="row category-row align-items-center position-relative mb-5">
                        <div class="decoration-shape shape-1"></div>
                <?php else: ?>
                    <div class="row category-row align-items-center position-relative mb-5">
                        <div class="decoration-shape shape-2"></div>
                <?php endif; ?>
                
                <?php if ($isEven): ?>
                    <!-- Left image, right text layout -->
                    <div class="col-md-6 mb-4 mb-md-0">
                        <a href="category-details.php?id=<?= $category['id_category'] ?>" class="category-link">
                            <div class="category-card shadow-sm">
                                <img src="<?=ROOT_PATH . '/root_uploads/categories/' .htmlspecialchars($category['image']); ?>" 
                                     alt="<?= htmlspecialchars($category['name']) ?>" class="category-image img-fluid">
                            </div>
                        </a>
                    </div>
                    <div class="col-md-5 offset-md-1">
                        <h2 class="category-name"><?= htmlspecialchars($category['name'])?></h2>
                        <div class="category-divider"></div>
                        <p class="category-description mb-3"><?= htmlspecialchars($category['description']) ?></p>
                        <a href="category-details.php?id=<?= $category['id_category'] ?>" class="explore-btn">
                            Explorer <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Left text, right image layout -->
                    <div class="col-md-5">
                        <h2 class="category-name"><?= htmlspecialchars($category['name']) ?></h2>
                        <div class="category-divider"></div>
                        <p class="category-description mb-3"><?= htmlspecialchars($category['description']) ?></p>
                        <a href="category-details.php?id=<?= $category['id_category'] ?>" class="explore-btn">
                            Explorer <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                    <div class="col-md-6 offset-md-1">
                        <a href="category-details.php?id=<?= $category['id_category'] ?>" class="category-link">
                            <div class="category-card shadow-sm">
                                <img src="../../root_uploads/categories/<?= htmlspecialchars($category['image']) ?>" 
                                     alt="<?= htmlspecialchars($category['name']) ?>" class="category-image img-fluid">
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                
                </div><!-- End row -->
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <?php include '../templates/Topbtn.php'; ?>
    <?php include '../templates/newsletter.php'; ?>
    <?php include '../templates/footer.php'; ?>

</body>
</html>