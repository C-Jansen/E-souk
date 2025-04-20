<?php 
session_start();

$page_title = "À propos - E-Souk Tounsi";
$page_description = "Découvrez notre histoire et notre mission de promotion de l'artisanat tunisien";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
    <link rel="icon" href="favicon.ico" type="./assets/images/favicon.ico" />
    
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
            <div class="row align-items-center" style="min-height: 50vh">
                <div class="col-lg-6 text-white position-relative z-2">
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2">Notre Histoire</span>
                    <h1 class="display-4 fw-bold mb-3">À Propos de E-Souk Tounsi</h1>
                    <p class="lead mb-4">Découvrez l'histoire de notre passion pour l'artisanat tunisien et notre mission de préservation du patrimoine culturel.</p>
                </div>
            </div>
        </div>
        <div class="curved-bottom">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100">
                <path fill="#4d5ae6" fill-opacity="1" d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,100L1360,100C1280,100,1120,100,960,100C800,100,640,100,480,100C320,100,160,100,80,100L0,100Z"></path>
            </svg>
        </div>
    </section>
        <!-- Notre Histoire Section -->
<section class="container py-5">
    <!-- Shape Divider Top -->
    <div class="shape-divider">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="rgb(77, 90, 230)"></path>
        </svg>
    </div>

    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="position-relative" style="width: 90%; margin: 0 auto;">
                <!-- Image with shadow but no border -->
                <img src="./assets/images/historic/1.jpg" alt="Notre Histoire" class="img-fluid rounded transition-standard" style="box-shadow: 0 15px 30px var(--color-shadow);">
                
                <!-- Decorative element - small accent border -->
                <div style="position: absolute; bottom: -15px; right: -15px; width: 60%; height: 60%; border: 3px solid var(--color-accent); border-radius: 10px; z-index: -1;"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ps-lg-4">
                <!-- Title with accent underline -->
                <h2 class="mb-4 position-relative">Notre Histoire
                    <span style="display: block; width: 80px; height: 3px; background: var(--color-accent); margin-top: 10px;"></span>
                </h2>
                
                <!-- First paragraph with highlight effect -->
                <p class="mb-4" style="border-left: 3px solid var(--color-accent); padding-left: 15px;">
                    Fondé en 2025, E-Souk Tounsi est né d'une passion profonde pour l'artisanat tunisien et d'une volonté de préserver ce patrimoine culturel inestimable. Face à la mondialisation et à l'industrialisation qui menacent les savoir-faire traditionnels, nous avons créé une plateforme permettant aux artisans tunisiens de partager leur art avec le monde entier.
                </p>
                
                <!-- Second paragraph -->
                <p class="mb-4">
                    Notre voyage a commencé par des rencontres avec des artisans dans différentes régions de la Tunisie, de Nabeul à Kairouan, de Djerba à Sejnane. Chaque rencontre nous a confortés dans notre conviction : ces trésors artisanaux méritent d'être connus et reconnus à l'échelle internationale.
                </p>
                
                <!-- Third paragraph with statistics -->
                <p class="mb-4">
                    Aujourd'hui, E-Souk Tounsi est fier de collaborer avec plus de 100 artisans à travers le pays, offrant une vitrine numérique à leur talent et contribuant à la préservation de techniques ancestrales.
                </p>
                
                <!-- Statistics display -->
                <div class="row text-center mt-4">
                    <div class="col-4">
                        <div style="background-color: var(--color-primary); color: white; border-radius: 8px; padding: 15px;">
                            <h4 class="mb-0">100+</h4>
                            <p class="mb-0 small">Artisans</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div style="background-color: var(--color-medium); color: white; border-radius: 8px; padding: 15px;">
                            <h4 class="mb-0">12</h4>
                            <p class="mb-0 small">Régions</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div style="background-color: var(--color-accent); color: white; border-radius: 8px; padding: 15px;">
                            <h4 class="mb-0">1500+</h4>
                            <p class="mb-0 small">Créations</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Shape Divider Bottom -->
    <div class="shape-divider-bottom">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="rgb(77, 90, 230)"></path>
        </svg>
    </div>
</section>

<!-- Notre Mission Section with Hover Effects -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="mb-4">Notre Mission</h2>
                <p class="lead mb-5">Chez E-Souk Tounsi, nous sommes guidés par des valeurs fortes et une mission claire qui définissent chacune de nos actions.</p>
                    <hr class="mx-auto" style="width: 60px; border: 2px solid #fcd34d">

            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm mission-card">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto mb-4 mission-icon" style="width: 80px; height: 80px;">
                            <i class="fas fa-hands text-white fa-2x"></i>
                        </div>
                        <h4 class="card-title mb-3">Préserver</h4>
                        <p class="card-text">Nous œuvrons à la préservation des techniques artisanales ancestrales en soutenant les artisans qui perpétuent ces traditions séculaires.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm mission-card">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto mb-4 mission-icon" style="width: 80px; height: 80px;">
                            <i class="fas fa-globe-africa text-white fa-2x"></i>
                        </div>
                        <h4 class="card-title mb-3">Connecter</h4>
                        <p class="card-text">Nous créons des ponts entre les artisans tunisiens et les amateurs d'art du monde entier, permettant un échange culturel enrichissant.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm mission-card">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto mb-4 mission-icon" style="width: 80px; height: 80px;">
                            <i class="fas fa-hand-holding-heart text-white fa-2x"></i>
                        </div>
                        <h4 class="card-title mb-3">Soutenir</h4>
                        <p class="card-text">Nous soutenons les communautés locales en assurant une rémunération équitable des artisans et en investissant dans le développement de leurs compétences.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Notre Équipe -->
<section class="container py-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="mb-4">Notre Équipe</h2>
            <p class="lead mb-5">Passionnés par l'artisanat et la culture tunisienne, nous mettons notre expertise au service de notre mission.</p>
                <hr class="mx-auto" style="width: 60px; border: 2px solid #fcd34d">
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm team-card">
                <img src="/api/placeholder/400/320" alt="Fondateur" class="card-img-top">
                <div class="card-body text-center p-4">
                    <h4 class="card-title mb-2">Ahmed Ben Salem</h4>
                    <p class="text-muted mb-3">Fondateur & Directeur</p>
                    <p class="card-text">Passionné d'artisanat depuis son enfance, Ahmed a parcouru la Tunisie pendant des années pour découvrir les savoir-faire régionaux avan</p>
                    <div class="social-icons mt-3">
                        <a href="#" class="text-primary me-2"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-primary"><i class="far fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm team-card">
                <img src="/api/placeholder/400/320" alt="Directrice Artistique" class="card-img-top">
                <div class="card-body text-center p-4">
                    <h4 class="card-title mb-2">Leila Mansouri</h4>
                    <p class="text-muted mb-3">Directrice Artistique</p>
                    <p class="card-text">Designer de formation, Leila apporte son œil expert pour la sélection des pièces et travaille étroitement avec les artisans pour allier</p>
                    <div class="social-icons mt-3">
                        <a href="#" class="text-primary me-2"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-primary"><i class="far fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm team-card">
                <img src="/api/placeholder/400/320" alt="Responsable Relations Artisans" class="card-img-top">
                <div class="card-body text-center p-4">
                    <h4 class="card-title mb-2">Karim Touati</h4>
                    <p class="text-muted mb-3">Relations Artisans</p>
                    <p class="card-text">Issu d'une famille d'artisans, Karim est le lien entre notre plateforme et notre réseau d'artisans, veillant à des partenariats équitab</p>
                    <div class="social-icons mt-3">
                        <a href="#" class="text-primary me-2"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-primary"><i class="far fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



    <!-- Call to Action -->
    <section class="bg-light py-5">
        <div class="container text-center">
            <h2 class="mb-4">Rejoignez l'Aventure E-Souk Tounsi</h2>
            <p class="lead mb-4">En achetant sur E-Souk Tounsi, vous soutenez l'artisanat tunisien et contribuez à préserver un patrimoine culturel unique.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="./product.php" class="btn btn-primary btn-lg px-4 shadow-sm">Découvrir nos produits</a>
                <a href="contact.php" class="btn btn-outline-primary btn-lg px-4">Nous contacter</a>
            </div>
        </div>
    </section>

    <!-- Partenaires -->
    <section class="container py-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="mb-4">Nos Partenaires</h2>
                <p class="lead mb-5">Ils nous font confiance et soutiennent notre mission.</p>
                <hr class="mx-auto" style="width: 60px; border: 2px solid #fcd34d"> 
            </div>
        </div>
        <div class="row g-4 align-items-center justify-content-center">
            <div class="col-4 col-md-2 text-center">
                <img src="/api/placeholder/120/80" alt="Partenaire 1" class="img-fluid opacity-75">
            </div>
            <div class="col-4 col-md-2 text-center">
                <img src="/api/placeholder/120/80" alt="Partenaire 2" class="img-fluid opacity-75">
            </div>
            <div class="col-4 col-md-2 text-center">
                <img src="/api/placeholder/120/80" alt="Partenaire 3" class="img-fluid opacity-75">
            </div>
            <div class="col-4 col-md-2 text-center">
                <img src="/api/placeholder/120/80" alt="Partenaire 4" class="img-fluid opacity-75">
            </div>
            <div class="col-4 col-md-2 text-center">
                <img src="/api/placeholder/120/80" alt="Partenaire 5" class="img-fluid opacity-75">
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <h3 class="mb-3">Restez informé de nos actualités</h3>
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