<?php 
session_start();
require_once __DIR__ . '/../../config/init.php';

$page_title = "Contactez-nous";
$page_description = "Contactez-nous pour toute question ou information supplémentaire.";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <?php include '../templates/header.php'; ?>
   
</head>
<body>
    <?php include '../templates/navbar.php'; ?>


     <section class="contact-section py-5 bg-light">
      <div class="container">
        <div class="text-center mb-5">
          <h2 class="fw-bold text-primary">Contactez-nous</h2>
          <p class="text-muted">
            Des questions ? Parlons-en. Contactez-nous dès maintenant.
          </p>
          <hr class="mx-auto" style="width: 60px; border: 2px solid #fcd34d" />
        </div>

        <div class="row g-4">
          <!-- Left: Infos pratiques -->
          <div class="col-md-6">
            <div
              class="p-4 rounded bg-white border border-primary-subtle shadow-sm"
            >
              <h5 class="text-primary fw-bold mb-4">Nos infos pratiques</h5>
              <ul class="list-unstyled text-muted">
                <li class="mb-3">
                  <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                  <strong>Adresse</strong><br />Tunis, Tunisia
                </li>
                <li class="mb-3">
                  <i class="fas fa-phone me-2 text-primary"></i>
                  <strong>Téléphone</strong><br />XXXXX
                </li>
                <li class="mb-3">
                  <i class="fas fa-envelope me-2 text-primary"></i>
                  <strong>Email</strong><br />E-souk@gmail.com
                </li>
                <li class="mb-3">
                  <i class="fas fa-clock me-2 text-primary"></i>
                  <strong>Horaires</strong><br />Mardi-Dimanche: 12h00 -
                  00h00<br />Lundi: Fermé
                </li>
                <li>
                  <i class="fab fa-instagram me-2 text-primary"></i>
                  <strong>Réseaux sociaux</strong><br />@E-souk.tn
                </li>
              </ul>
            </div>
          </div>

          <!-- Right: Formulaire -->
          <div class="col-md-6">
            <div
              class="p-4 rounded bg-white border border-primary-subtle shadow-sm"
            >
              <h5 class="text-primary fw-bold mb-4">Besoin de nous parler ?</h5>
              <form>
                <div class="row mb-3">
                  <div class="col">
                    <input
                      type="text"
                      class="form-control"
                      placeholder="Votre nom"
                      required
                    />
                  </div>
                  <div class="col">
                    <input
                      type="email"
                      class="form-control"
                      placeholder="Votre email"
                      required
                    />
                  </div>
                </div>
                <div class="mb-3">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Sujet"
                    required
                  />
                </div>
                <div class="mb-3">
                  <textarea
                    class="form-control"
                    rows="5"
                    placeholder="Votre message"
                    required
                  ></textarea>
                </div>
                <button type="submit" class="btn btn-primary px-4">
                  Envoyer le message
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include '../templates/Topbtn.php'; ?>
    <?php include '../templates/newsletter.php'; ?>
    <?php include '../templates/footer.php'; ?>

</body>
</html>
